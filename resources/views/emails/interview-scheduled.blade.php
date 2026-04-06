<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Wawancara PPDB</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .email-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1a5f2a, #28a745);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .schedule-box {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-left: 4px solid #28a745;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .schedule-item {
            display: flex;
            margin-bottom: 15px;
        }
        .schedule-item:last-child {
            margin-bottom: 0;
        }
        .schedule-label {
            font-weight: 600;
            color: #666;
            width: 120px;
            flex-shrink: 0;
        }
        .schedule-value {
            color: #333;
            font-weight: 500;
        }
        .highlight {
            background: #28a745;
            color: white;
            padding: 2px 8px;
            border-radius: 5px;
            font-weight: 600;
        }
        .notes-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .notes-box h4 {
            margin: 0 0 10px;
            color: #856404;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .footer p {
            margin: 5px 0;
        }
        .tips {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .tips h4 {
            margin: 0 0 10px;
            color: #1565c0;
        }
        .tips ul {
            margin: 0;
            padding-left: 20px;
        }
        .tips li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>📋 Jadwal Wawancara PPDB</h1>
            <p>{{ config('app.name', 'Maskanul Huffadz') }}</p>
        </div>
        
        <div class="content">
            <p class="greeting">
                Assalamu'alaikum Wr. Wb.<br>
                <strong>{{ $santriName }}</strong>,
            </p>
            
            <p>
                Alhamdulillah, wawancara PPDB Anda telah dijadwalkan. Berikut adalah detail jadwal wawancara Anda:
            </p>
            
            <div class="schedule-box">
                <div class="schedule-item">
                    <span class="schedule-label">📅 Tanggal</span>
                    <span class="schedule-value highlight">{{ \Carbon\Carbon::parse($scheduleDate)->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="schedule-item">
                    <span class="schedule-label">⏰ Waktu</span>
                    <span class="schedule-value highlight">{{ $scheduleTime }} WIB</span>
                </div>
                <div class="schedule-item">
                    <span class="schedule-label">📱 Media</span>
                    <span class="schedule-value">{{ $media }}</span>
                </div>
                <div class="schedule-item">
                    <span class="schedule-label">👤 Pewawancara</span>
                    <span class="schedule-value">{{ $ustadName }}</span>
                </div>
                <div class="schedule-item">
                    <span class="schedule-label">📚 Program</span>
                    <span class="schedule-value">{{ $programName }}</span>
                </div>
            </div>
            
            @if($notes)
            <div class="notes-box">
                <h4>📝 Catatan dari Panitia:</h4>
                <p style="margin: 0;">{{ $notes }}</p>
            </div>
            @endif
            
            <div class="tips">
                <h4>💡 Tips Persiapan:</h4>
                <ul>
                    <li>Pastikan koneksi internet stabil (jika wawancara online)</li>
                    <li>Siapkan Al-Quran untuk tes bacaan</li>
                    <li>Berpakaian rapi dan sopan</li>
                    <li>Hadir tepat waktu atau 10 menit sebelumnya</li>
                </ul>
            </div>
            
            <p style="margin-top: 25px;">
                Jika ada pertanyaan, silakan hubungi panitia PPDB.<br><br>
                Wassalamu'alaikum Wr. Wb.
            </p>
        </div>
        
        <div class="footer">
            <p><strong>{{ config('app.name', 'Maskanul Huffadz') }}</strong></p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
