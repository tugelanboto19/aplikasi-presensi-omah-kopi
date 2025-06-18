<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kartu Karyawan - {{ $employee->nama_lengkap }}</title>
  <style>
    body {
      background-color: #e0e0e0;
      /* Latar abu-abu muda untuk preview di browser */
      margin: 0;
      padding: 20px;
      /* Padding agar kartu tidak mepet saat dibuka langsung */
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }

    .employee-id-card {
      width: 204px;
      /* Sekitar 5.4cm jika 96 DPI */
      height: 324px;
      /* Sekitar 8.6cm jika 96 DPI (Portrait) */
      padding: 12px;
      /* Padding internal kartu dikurangi sedikit */
      border: 1px solid #A0522D;
      /* Border coklat sienna */
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      text-align: center;
      /* Latar belakang gradasi coklat untuk kartu */
      background: linear-gradient(145deg, #D2B48C 0%, #BC8F8F 100%);
      /* Tan ke RosyBrown */
      /* Alternatif: background-color: #EADDCA; (Warna krem kayu muda) */
      color: #4A3B31;
      /* Warna teks utama coklat tua */
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      /* Distribusi ruang lebih baik */
    }

    .employee-id-card .card-header {
      /* Bagian untuk logo dan nama perusahaan */
      margin-bottom: 8px;
    }

    .employee-id-card .logo-omah-kopi {
      width: 50px;
      /* Sesuaikan ukuran logo Anda */
      height: auto;
      margin: 0 auto 5px auto;
      display: block;
    }

    .employee-id-card .company-title h2 {
      font-size: 0.8rem;
      /* 12.8px */
      font-weight: 600;
      margin-bottom: 0px;
      color: #603813;
      /* Coklat lebih tua */
    }

    .employee-id-card .company-title h4 {
      font-size: 0.6rem;
      /* 9.6px */
      color: #7D4F34;
      margin-bottom: 5px;
    }

    .employee-id-card hr {
      margin: 5px auto;
      border-top: 1px dashed #B08D57;
      /* Garis putus-putus coklat muda */
      width: 90%;
    }

    .employee-id-card .employee-name {
      font-size: 1rem;
      /* 16px - sedikit diperkecil agar muat */
      font-weight: 700;
      margin-top: 5px;
      margin-bottom: 1px;
      color: #4A3B31;
      line-height: 1.2;
    }

    .employee-id-card .employee-position {
      font-size: 0.7rem;
      /* 11.2px */
      color: #5C4033;
      /* Coklat sedikit lebih terang */
      margin-bottom: 6px;
    }

    .employee-id-card .qr-code-container {
      margin: 6px auto;
      padding: 5px;
      background-color: #fff;
      /* Latar putih untuk QR agar mudah di-scan */
      border: 1px solid #D2B48C;
      /* Border tan */
      border-radius: 6px;
      display: inline-block;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .employee-id-card .qr-code-container svg,
    .employee-id-card .qr-code-container img {
      display: block;
      width: 110px;
      /* Ukuran QR Code disesuaikan lagi */
      height: 110px;
      margin: auto;
    }

    .employee-id-card .employee-id-unik {
      font-size: 0.6rem;
      /* 9.6px */
      font-family: monospace;
      color: #603813;
      background-color: rgba(255, 255, 255, 0.5);
      /* Latar semi transparan */
      padding: 2px 4px;
      border-radius: 3px;
      display: inline-block;
      margin-top: 6px;
      /* Margin atas dari QR */
      word-break: break-all;
    }

    .employee-id-card .footer-text {
      font-size: 0.55rem;
      /* 8.8px - diperkecil dan dinaikkan */
      color: #7D4F34;
      margin-top: 4px;
      /* Margin atas dikurangi agar lebih naik */
      font-style: italic;
    }

    .action-buttons {
      text-align: center;
      margin-top: 20px;
    }

    .action-buttons button {
      padding: 8px 15px;
      margin: 0 5px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 0.9rem;
      cursor: pointer;
      background-color: #8B4513;
      /* SaddleBrown */
      color: white;
      border: none;
      transition: background-color 0.2s ease;
    }

    .action-buttons button:hover {
      background-color: #A0522D;
      /* Sienna */
    }

    @media print {
      body {
        background-color: #fff !important;
        margin: 0 !important;
        padding: 0 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }

      .employee-id-card {
        width: 54mm !important;
        height: 85.6mm !important;
        padding: 3.5mm !important;
        /* Padding dikurangi sedikit untuk print */
        margin: 0 auto !important;
        border: 0.25mm solid #888 !important;
        box-shadow: none !important;
        page-break-inside: avoid !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        /* Distribusi ruang lebih baik */
        align-items: center !important;
        background: linear-gradient(145deg, #D2B48C 0%, #BC8F8F 100%) !important;
        /* Pastikan background tercetak */
        color: #4A3B31 !important;
      }

      .employee-id-card .logo-omah-kopi {
        width: 12mm !important;
        /* Ukuran logo untuk print */
        margin-bottom: 1mm !important;
      }

      .employee-id-card .company-title h2 {
        font-size: 7pt !important;
        margin-bottom: 0.25mm !important;
        color: #603813 !important;
      }

      .employee-id-card .company-title h4 {
        font-size: 5pt !important;
        margin-bottom: 1mm !important;
        color: #7D4F34 !important;
      }

      .employee-id-card hr {
        margin: 1mm auto !important;
        border-top: 0.25mm dashed #B08D57 !important;
      }

      .employee-id-card .employee-name {
        font-size: 10pt !important;
        margin-top: 1mm !important;
        margin-bottom: 0.25mm !important;
        color: #4A3B31 !important;
      }

      .employee-id-card .employee-position {
        font-size: 6.5pt !important;
        margin-bottom: 1.5mm !important;
        color: #5C4033 !important;
      }

      .employee-id-card .qr-code-container {
        margin: 1.5mm auto !important;
        padding: 1mm !important;
        background-color: #fff !important;
        border: 0.25mm solid #D2B48C !important;
      }

      .employee-id-card .qr-code-container svg,
      .employee-id-card .qr-code-container img {
        width: 25mm !important;
        /* Ukuran QR di kartu cetak */
        height: 25mm !important;
      }

      .employee-id-card .employee-id-unik {
        font-size: 5pt !important;
        margin-top: 1.5mm !important;
        padding: 0.5mm 1mm !important;
        background-color: rgba(255, 255, 255, 0.7) !important;
        color: #603813 !important;
      }

      .employee-id-card .footer-text {
        font-size: 5pt !important;
        margin-top: 1mm !important;
        color: #7D4F34 !important;
      }

      .action-buttons,
      .no-print-in-iframe {
        display: none !important;
      }

      body * {
        visibility: hidden;
      }

      .employee-id-card,
      .employee-id-card * {
        visibility: visible;
      }
    }
  </style>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
  <div class="employee-id-card">
    <div class="card-header">
      {{-- Ganti dengan path logo Anda yang sebenarnya --}}
      <img src="{{ asset('img/logo.png') }}" alt="Logo Omah Kopi Mrisen" class="logo-omah-kopi">
      <div class="company-title">
        <h2>Kartu Karyawan</h2>
        <h4>Omah Kopi Mrisen</h4>
      </div>
    </div>
    <hr>
    <div class="employee-info">
      <h3 class="employee-name">{{ $employee->nama_lengkap }}</h3>
      <p class="employee-position">Posisi: {{ $employee->posisi }}</p>
    </div>
    <div class="qr-code-container">
      {!! QrCode::size(110)->generate($employee->employee_id_unik) !!}
    </div>
    <p class="employee-id-unik"><code>{{ $employee->employee_id_unik }}</code></p>

  </div>

  <div class="action-buttons no-print-in-iframe">
    <button class="btn-print" onclick="window.print()">Cetak Kartu</button>
  </div>
</body>

</html>