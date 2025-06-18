<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MonthlyAttendanceReportExport implements FromView, WithEvents, WithTitle
{
    protected $bulan;
    protected $tahun;
    protected $employee_id;
    protected $employee;
    protected $attendances;
    protected $monthName;
    protected $summary;

    public function __construct(int $bulan, int $tahun, ?int $employee_id)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->employee_id = $employee_id;
        $this->monthName = Carbon::create()->month($this->bulan)->isoFormat('MMMM');

        if (!empty($this->employee_id)) {
            $this->employee = Employee::find($this->employee_id);
            $all_attendances = Attendance::where('employee_id', $this->employee_id)
                ->whereYear('tanggal', $this->tahun)
                ->whereMonth('tanggal', $this->bulan)
                ->get();

            $this->prepareDataForView($all_attendances);
        }
    }

    protected function prepareDataForView($all_attendances)
    {
        $attendances_by_date = $all_attendances->keyBy('tanggal');
        $daysInMonth = Carbon::create($this->tahun, $this->bulan)->daysInMonth;

        $this->summary = [
            'hadir_pulang' => 0,
            'sakit' => 0,
            'izin' => 0,
            'alpha' => 0,
            'libur' => 0,
            'total_detik_kerja' => 0
        ];

        $calendar_data = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = Carbon::create($this->tahun, $this->bulan, $day);
            $dateString = $currentDate->toDateString();

            $day_data = [
                'full_date' => $currentDate->isoFormat('dddd, D MMMM Y'),
                'jam_masuk' => '-',
                'jam_keluar' => '-',
                'status' => 'LIBUR',
                'work_duration' => '0 jam 0 menit 0 detik',
                'keterangan' => '-'
            ];

            if (isset($attendances_by_date[$dateString])) {
                $attendance = $attendances_by_date[$dateString];
                $day_data['jam_masuk'] = $attendance->jam_masuk ? Carbon::parse($attendance->jam_masuk)->format('H:i:s') : '-';
                $day_data['jam_keluar'] = $attendance->jam_keluar ? Carbon::parse($attendance->jam_keluar)->format('H:i:s') : '-';
                $day_data['status'] = $attendance->status;
                $day_data['keterangan'] = $attendance->keterangan ?? '-';

                if ($attendance->jam_masuk && $attendance->jam_keluar) {
                    // *** PERBAIKAN LOGIKA DI SINI ***
                    // Menggabungkan tanggal dari database dengan waktu untuk parsing yang akurat
                    $jamMasuk = Carbon::parse($attendance->tanggal . ' ' . $attendance->jam_masuk);
                    $jamKeluar = Carbon::parse($attendance->tanggal . ' ' . $attendance->jam_keluar);

                    $diffInSeconds = $jamKeluar->diffInSeconds($jamMasuk);
                    $this->summary['total_detik_kerja'] += $diffInSeconds;
                    $day_data['work_duration'] = gmdate('H\ \j\a\m i\ \m\e\n\i\t s\ \d\e\t\i\k', $diffInSeconds);
                }

                switch ($attendance->status) {
                    case 'Hadir':
                    case 'Pulang':
                        $this->summary['hadir_pulang']++;
                        break;
                    case 'Sakit':
                        $this->summary['sakit']++;
                        break;
                    case 'Izin':
                        $this->summary['izin']++;
                        break;
                    case 'Alpha':
                        $this->summary['alpha']++;
                        break;
                }
            } else {
                $this->summary['libur']++;
            }
            $calendar_data[] = $day_data;
        }

        $this->attendances = $calendar_data;
        $this->summary['total_hari_efektif'] = $this->summary['hadir_pulang'];
    }

    public function view(): View
    {
        if (!$this->employee) {
            return view('reports.exports.monthly_report_default'); // Anda bisa buat view ini untuk menampilkan pesan error jika diperlukan
        }

        return view('reports.exports.monthly_report_export_template', [
            'employee' => $this->employee,
            'attendances' => $this->attendances,
            'summary' => $this->summary,
            'monthName' => $this->monthName,
            'year' => $this->tahun
        ]);
    }

    public function title(): string
    {
        return 'Laporan ' . $this->monthName . ' ' . $this->tahun;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                if (!$this->employee) return;

                $sheet = $event->sheet->getDelegate();

                $sheet->getColumnDimension('A')->setWidth(30);
                $sheet->getColumnDimension('B')->setWidth(15);
                $sheet->getColumnDimension('C')->setWidth(15);
                $sheet->getColumnDimension('D')->setWidth(12);
                $sheet->getColumnDimension('E')->setWidth(25);
                $sheet->getColumnDimension('F')->setWidth(30);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $headerRow = 7;
                $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)->getFont()->setBold(true);
                $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $lastRow = count($this->attendances) + $headerRow;
                $summaryRowStart = $lastRow + 2;
                $summaryLastRow = $summaryRowStart + 8;

                $sheet->getStyle('A' . $summaryRowStart)->getFont()->setBold(true);

                $styleArray = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
                $sheet->getStyle('A' . $headerRow . ':F' . $lastRow)->applyFromArray($styleArray);
                $sheet->getStyle('A' . $summaryRowStart . ':C' . $summaryLastRow)->applyFromArray($styleArray);
            },
        ];
    }
}
