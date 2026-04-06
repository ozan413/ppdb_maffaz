<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Santri - {{ $registration->user->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 15mm;
            background: white;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #1565C0;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 16pt;
            color: #1565C0;
            margin-bottom: 3px;
        }

        .header h2 {
            font-size: 12pt;
            font-weight: normal;
            color: #666;
        }

        .header .program-badge {
            display: inline-block;
            background: linear-gradient(135deg, #1565C0, #1976D2);
            color: white;
            padding: 4px 15px;
            border-radius: 20px;
            font-size: 10pt;
            margin-top: 8px;
        }

        .content-wrapper {
            display: flex;
            gap: 20px;
        }

        .main-content {
            flex: 1;
        }

        .photo-section {
            width: 100px;
            flex-shrink: 0;
        }

        .photo-box {
            width: 100px;
            height: 130px;
            border: 2px solid #ddd;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            overflow: hidden;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-label {
            text-align: center;
            font-size: 8pt;
            color: #666;
            margin-top: 3px;
        }

        .section {
            margin-bottom: 12px;
        }

        .section-title {
            background: linear-gradient(135deg, #1565C0, #1976D2);
            color: white;
            padding: 5px 12px;
            font-size: 10pt;
            font-weight: 600;
            border-radius: 4px 4px 0 0;
        }

        .section-content {
            border: 1px solid #ddd;
            border-top: none;
            padding: 10px 12px;
            border-radius: 0 0 4px 4px;
        }

        .data-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px 20px;
        }

        .data-row {
            display: flex;
            padding: 3px 0;
            border-bottom: 1px dotted #eee;
        }

        .data-row.full {
            grid-column: 1 / -1;
        }

        .data-label {
            width: 140px;
            font-weight: 600;
            color: #555;
            font-size: 9pt;
            flex-shrink: 0;
        }

        .data-value {
            flex: 1;
            color: #333;
            font-size: 9pt;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 15px;
            font-size: 9pt;
            font-weight: 600;
        }

        .status-lulus { background: #d4edda; color: #155724; }
        .status-tidak-lulus { background: #f8d7da; color: #721c24; }
        .status-menunggu { background: #fff3cd; color: #856404; }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
            color: #666;
        }

        .signature-box {
            text-align: center;
            width: 150px;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            margin-top: 50px;
            margin-bottom: 3px;
        }

        @media print {
            body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .container { padding: 8mm; }
            .no-print { display: none !important; }
        }

        .print-btn {
            position: fixed;
            top: 15px;
            right: 15px;
            background: #1565C0;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        .print-btn:hover {
            background: #0D47A1;
        }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="window.print()">
        🖨️ Cetak / Download PDF
    </button>

    <div class="container">
        <div class="header">
            <h1>PONDOK PESANTREN MASKANUL HUFFADZ</h1>
            <h2>Formulir Data Pendaftaran Santri</h2>
            <span class="program-badge">{{ $registration->program->name }}</span>
        </div>

        <div class="content-wrapper">
            <div class="main-content">
                <!-- Status Pendaftaran -->
                <div class="section">
                    <div class="section-title">📋 Status Pendaftaran</div>
                    <div class="section-content">
                        <div class="data-grid">
                            <div class="data-row">
                                <div class="data-label">Nama Akun</div>
                                <div class="data-value">{{ $registration->user->name }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">Status</div>
                                <div class="data-value">
                                    @if($registration->graduationDecision && $registration->graduationDecision->is_lulus)
                                        <span class="status-badge status-lulus">LULUS</span>
                                    @elseif($registration->graduationDecision && !$registration->graduationDecision->is_lulus)
                                        <span class="status-badge status-tidak-lulus">TIDAK LULUS</span>
                                    @else
                                        <span class="status-badge status-menunggu">MENUNGGU</span>
                                    @endif
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">Tanggal Daftar</div>
                                <div class="data-value">{{ $registration->created_at->format('d F Y') }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">Email</div>
                                <div class="data-value">{{ $registration->user->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($programData)
                <!-- Data Diri -->
                <div class="section">
                    <div class="section-title">👤 Data Diri Santri</div>
                    <div class="section-content">
                        <div class="data-grid">
                            @if(isset($programData->nama_lengkap))
                            <div class="data-row">
                                <div class="data-label">Nama Lengkap</div>
                                <div class="data-value">{{ $programData->nama_lengkap }}</div>
                            </div>
                            @endif

                            @if(isset($programData->nama_panggilan))
                            <div class="data-row">
                                <div class="data-label">Nama Panggilan</div>
                                <div class="data-value">{{ $programData->nama_panggilan }}</div>
                            </div>
                            @endif

                            @if(isset($programData->tempat_lahir))
                            <div class="data-row">
                                <div class="data-label">Tempat Lahir</div>
                                <div class="data-value">{{ $programData->tempat_lahir }}</div>
                            </div>
                            @endif

                            @if(isset($programData->tanggal_lahir))
                            <div class="data-row">
                                <div class="data-label">Tanggal Lahir</div>
                                <div class="data-value">{{ $programData->tanggal_lahir instanceof \Carbon\Carbon ? $programData->tanggal_lahir->format('d F Y') : $programData->tanggal_lahir }}</div>
                            </div>
                            @endif

                            @if(isset($programData->usia))
                            <div class="data-row">
                                <div class="data-label">Usia</div>
                                <div class="data-value">{{ $programData->usia }} tahun</div>
                            </div>
                            @endif

                            @if(isset($programData->gender))
                            <div class="data-row">
                                <div class="data-label">Jenis Kelamin</div>
                                <div class="data-value">{{ $programData->gender }}</div>
                            </div>
                            @endif

                            @if(isset($programData->no_hp))
                            <div class="data-row">
                                <div class="data-label">No. HP</div>
                                <div class="data-value">{{ $programData->no_hp }}</div>
                            </div>
                            @endif

                            @if(isset($programData->email))
                            <div class="data-row">
                                <div class="data-label">Email</div>
                                <div class="data-value">{{ $programData->email }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                @if(isset($programData->domisili_lengkap) || isset($programData->provinsi_domisili))
                <div class="section">
                    <div class="section-title">🏠 Alamat</div>
                    <div class="section-content">
                        <div class="data-grid">
                            @if(isset($programData->provinsi_domisili))
                            <div class="data-row">
                                <div class="data-label">Provinsi</div>
                                <div class="data-value">{{ $programData->provinsi_domisili }}</div>
                            </div>
                            @endif

                            @if(isset($programData->kota_kabupaten))
                            <div class="data-row">
                                <div class="data-label">Kota/Kabupaten</div>
                                <div class="data-value">{{ $programData->kota_kabupaten }}</div>
                            </div>
                            @endif

                            @if(isset($programData->domisili_lengkap))
                            <div class="data-row full">
                                <div class="data-label">Alamat Lengkap</div>
                                <div class="data-value">{{ $programData->domisili_lengkap }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Pendidikan -->
                @if(isset($programData->pendidikan_terakhir) || isset($programData->riwayat_pendidikan_formal))
                <div class="section">
                    <div class="section-title">🎓 Pendidikan</div>
                    <div class="section-content">
                        <div class="data-grid">
                            @if(isset($programData->pendidikan_terakhir))
                            <div class="data-row">
                                <div class="data-label">Pendidikan Terakhir</div>
                                <div class="data-value">{{ $programData->pendidikan_terakhir }}</div>
                            </div>
                            @endif

                            @if(isset($programData->riwayat_pendidikan_formal))
                            <div class="data-row full">
                                <div class="data-label">Riwayat Formal</div>
                                <div class="data-value">{{ $programData->riwayat_pendidikan_formal }}</div>
                            </div>
                            @endif

                            @if(isset($programData->riwayat_pendidikan_nonformal))
                            <div class="data-row full">
                                <div class="data-label">Riwayat Non-formal</div>
                                <div class="data-value">{{ $programData->riwayat_pendidikan_nonformal }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Data Orang Tua -->
                @if(isset($programData->nama_ayah) || isset($programData->nama_ibu))
                <div class="section">
                    <div class="section-title">👨‍👩‍👧 Data Orang Tua</div>
                    <div class="section-content">
                        <div class="data-grid">
                            @if(isset($programData->nama_ayah))
                            <div class="data-row">
                                <div class="data-label">Nama Ayah</div>
                                <div class="data-value">{{ $programData->nama_ayah }}</div>
                            </div>
                            @endif

                            @if(isset($programData->pekerjaan_ayah))
                            <div class="data-row">
                                <div class="data-label">Pekerjaan Ayah</div>
                                <div class="data-value">{{ $programData->pekerjaan_ayah }}</div>
                            </div>
                            @endif

                            @if(isset($programData->penghasilan_ayah))
                            <div class="data-row">
                                <div class="data-label">Penghasilan Ayah</div>
                                <div class="data-value">{{ $programData->penghasilan_ayah }}</div>
                            </div>
                            @endif

                            @if(isset($programData->nama_ibu))
                            <div class="data-row">
                                <div class="data-label">Nama Ibu</div>
                                <div class="data-value">{{ $programData->nama_ibu }}</div>
                            </div>
                            @endif

                            @if(isset($programData->pekerjaan_ibu))
                            <div class="data-row">
                                <div class="data-label">Pekerjaan Ibu</div>
                                <div class="data-value">{{ $programData->pekerjaan_ibu }}</div>
                            </div>
                            @endif

                            @if(isset($programData->penghasilan_ibu))
                            <div class="data-row">
                                <div class="data-label">Penghasilan Ibu</div>
                                <div class="data-value">{{ $programData->penghasilan_ibu }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Khusus Lil Athfal & Iddah Tahfidz - Pengalaman Menghafal -->
                @if(isset($programData->pengalaman_menghafal))
                <div class="section">
                    <div class="section-title">📖 Pengalaman Menghafal Al-Quran</div>
                    <div class="section-content">
                        <div class="data-grid">
                            <div class="data-row">
                                <div class="data-label">Pengalaman</div>
                                <div class="data-value">{{ $programData->pengalaman_menghafal }}</div>
                            </div>

                            @if(isset($programData->jumlah_hafalan))
                            <div class="data-row">
                                <div class="data-label">Jumlah Hafalan</div>
                                <div class="data-value">{{ $programData->jumlah_hafalan }}</div>
                            </div>
                            @endif

                            @if(isset($programData->pemahaman_tajwid))
                            <div class="data-row">
                                <div class="data-label">Pemahaman Tajwid</div>
                                <div class="data-value">{{ $programData->pemahaman_tajwid }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Khusus Paudqu - Program -->
                @if(isset($programData->program_pilihan) || isset($programData->durasi_program))
                <div class="section">
                    <div class="section-title">📚 Info Program</div>
                    <div class="section-content">
                        <div class="data-grid">
                            @if(isset($programData->program_pilihan))
                            <div class="data-row">
                                <div class="data-label">Program Pilihan</div>
                                <div class="data-value">{{ $programData->program_pilihan }}</div>
                            </div>
                            @endif

                            @if(isset($programData->durasi_program))
                            <div class="data-row">
                                <div class="data-label">Durasi Program</div>
                                <div class="data-value">{{ $programData->durasi_program }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Riwayat Kesehatan -->
                @if(isset($programData->riwayat_sakit) || isset($programData->riwayat_kesehatan) || isset($programData->riwayat_alergi))
                <div class="section">
                    <div class="section-title">🏥 Riwayat Kesehatan</div>
                    <div class="section-content">
                        <div class="data-grid">
                            @if(isset($programData->riwayat_sakit))
                            <div class="data-row full">
                                <div class="data-label">Riwayat Sakit</div>
                                <div class="data-value">{{ $programData->riwayat_sakit ?: '-' }}</div>
                            </div>
                            @endif

                            @if(isset($programData->riwayat_kesehatan))
                            <div class="data-row full">
                                <div class="data-label">Riwayat Kesehatan</div>
                                <div class="data-value">{{ $programData->riwayat_kesehatan ?: '-' }}</div>
                            </div>
                            @endif

                            @if(isset($programData->riwayat_alergi))
                            <div class="data-row full">
                                <div class="data-label">Riwayat Alergi</div>
                                <div class="data-value">{{ $programData->riwayat_alergi ?: '-' }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Sumber Informasi -->
                @if(isset($programData->sumber_informasi))
                <div class="section">
                    <div class="section-title">ℹ️ Informasi Tambahan</div>
                    <div class="section-content">
                        <div class="data-row">
                            <div class="data-label">Sumber Informasi</div>
                            <div class="data-value">{{ $programData->sumber_informasi }}</div>
                        </div>
                    </div>
                </div>
                @endif
                @else
                <div class="section">
                    <div class="section-content" style="text-align: center; padding: 30px; color: #999;">
                        Data biodata belum diisi
                    </div>
                </div>
                @endif
            </div>

            <div class="photo-section">
                <div class="photo-box">
                    @if($programData && isset($programData->pas_foto) && $programData->pas_foto)
                        <img src="{{ asset('storage/' . $programData->pas_foto) }}" alt="Foto Santri">
                    @else
                        <span style="color: #999; font-size: 9pt; text-align: center;">Pas Foto<br>3x4</span>
                    @endif
                </div>
                <div class="photo-label">Pas Foto</div>
            </div>
        </div>

        <div class="footer">
            <div>
                <small>Dicetak: {{ now()->format('d/m/Y H:i') }}</small>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <span>Panitia PPDB</span>
            </div>
        </div>
    </div>
</body>
</html>
