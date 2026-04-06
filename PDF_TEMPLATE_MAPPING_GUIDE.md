# Panduan Mapping PDF Template

## Overview

Sistem sudah siap untuk mengisi data ke template PDF `Format Formulir I'dad Tahfidz.pdf`. Karena FPDI tidak mendukung isi form fields otomatis, kita perlu melakukan **text overlay** dengan koordinat manual.

## Cara Kerja

1. Sistem load template PDF dari `storage/app/templates/Format Formulir I'dad Tahfidz.pdf`
2. Ambil semua data santri dari database
3. Overlay text di koordinat yang sudah ditentukan
4. Export sebagai PDF yang sudah terisi

## Cara Mapping Koordinat

### Step 1: Buka Template PDF

Buka file `Format Formulir I'dad Tahfidz.pdf` di PDF reader

### Step 2: Tentukan Koordinat Field

Untuk menentukan koordinat (X, Y) di mana text harus ditulis:

- **X**: Jarak dari kiri (dalam milimeter)
- **Y**: Jarak dari atas (dalam milimeter)
- **Ukuran kertas A4**: 210mm x 297mm

### Step 3: Edit Controller

Edit file `app/Http/Controllers/Panitia/DataSantriController.php` di method `downloadPdfTemplate()`:

```php
// Contoh mapping koordinat
// Ganti angka 60, 50 dengan koordinat sebenarnya

// Nama Lengkap - misalnya di koordinat X:60mm, Y:50mm dari kiri atas
if (isset($data['nama_lengkap'])) {
    $pdf->SetXY(60, 50);
    $pdf->Write(0, $data['nama_lengkap']);
}

// Program - koordinat X:60mm, Y:60mm
if (isset($data['program'])) {
    $pdf->SetXY(60, 60);
    $pdf->Write(0, $data['program']);
}

// Tempat Lahir
if (isset($data['tempat_lahir'])) {
    $pdf->SetXY(60, 70);
    $pdf->Write(0, $data['tempat_lahir']);
}

// Tanggal Lahir
if (isset($data['tanggal_lahir'])) {
    $pdf->SetXY(60, 80);
    $pdf->Write(0, $data['tanggal_lahir']);
}

// Dan seterusnya untuk semua field...
```

## Data Yang Tersedia

Semua data disimpan dalam array `$data`, tersedia:

### Data Pendaftaran

- `nama_akun`
- `email`
- `program`
- `tanggal_daftar`
- `status_kelulusan`

### Data Diri

- `nama_lengkap`
- `nama_panggilan`
- `tempat_lahir`
- `tanggal_lahir`
- `usia`
- `gender`
- `no_hp`
- `email_santri`

### Alamat

- `provinsi`
- `kota_kabupaten`
- `alamat_lengkap`

### Pendidikan

- `pendidikan_terakhir`
- `riwayat_pendidikan_formal`
- `riwayat_pendidikan_nonformal`

### Orang Tua

- `nama_ayah`
- `pekerjaan_ayah`
- `penghasilan_ayah`
- `nama_ibu`
- `pekerjaan_ibu`
- `penghasilan_ibu`

### Data Daftar Ulang

- `nik`
- `nisn`
- `jumlah_saudara`
- `kelas_jenjang_pendidikan`
- `ukuran_jubah`
- `prestasi`
- `jumlah_hafalan_juz`
- `pendidikan_ayah`
- `no_telepon_ayah`
- `pendidikan_ibu`
- `no_telepon_ibu`
- `nama_wali`
- `alamat_ortu_wali`

## Tips Mapping

### 1. Cara Cepat Menentukan Koordinat

1. Coba dengan koordinat awal (misal: 60, 50)
2. Download PDF hasil
3. Lihat apakah posisi sudah tepat
4. Sesuaikan koordinat sampai pas

### 2. Mengatur Font Size

```php
$pdf->SetFont('Arial', '', 10);  // Normal
$pdf->SetFont('Arial', 'B', 12); // Bold, size 12
```

### 3. Multiple Pages

Jika template punya beberapa halaman, loop sudah otomatis handle:

```php
for ($pageNo = 2; $pageNo <= $pageCount; $pageNo++) {
    $tplId = $pdf->importPage($pageNo);
    $pdf->AddPage();
    $pdf->useTemplate($tplId);

    // Tambahkan overlay untuk halaman 2, 3, dst
}
```

## Alternatif: Fillable PDF Form

Jika template PDF Anda punya **form fields** (fillable PDF), gunakan library tambahan:

```bash
composer require setasign/setapdf-formfiller
```

Dengan fillable PDF, Anda tidak perlu koordinat manual, cukup:

```php
$formFiller->fillField('nama_lengkap', $data['nama_lengkap']);
```

## Contoh Lengkap

```php
// Halaman 1
$tplId = $pdf->importPage(1);
$pdf->AddPage();
$pdf->useTemplate($tplId);

$pdf->SetFont('Arial', '', 10);

// Data Pribadi
$pdf->SetXY(70, 45); $pdf->Write(0, $data['nama_lengkap'] ?? '');
$pdf->SetXY(70, 52); $pdf->Write(0, $data['tempat_lahir'] ?? '');
$pdf->SetXY(70, 59); $pdf->Write(0, $data['tanggal_lahir'] ?? '');
$pdf->SetXY(70, 66); $pdf->Write(0, $data['usia'] ?? '');
$pdf->SetXY(70, 73); $pdf->Write(0, $data['gender'] ?? '');

// Data Alamat
$pdf->SetXY(70, 85); $pdf->Write(0, $data['provinsi'] ?? '');
$pdf->SetXY(70, 92); $pdf->Write(0, $data['kota_kabupaten'] ?? '');
$pdf->SetXY(70, 99); $pdf->Write(0, $data['alamat_lengkap'] ?? '');

// ... dan seterusnya
```

## Troubleshooting

### PDF Tidak Muncul Text

- Periksa koordinat (X, Y) sudah benar
- Pastikan font sudah di-set
- Cek warna text (SetTextColor)

### Text Terpotong

- Font size terlalu besar
- Koordinat X terlalu ke kanan
- Gunakan MultiCell untuk text panjang:
    ```php
    $pdf->SetXY(70, 99);
    $pdf->MultiCell(120, 5, $data['alamat_lengkap'], 0, 'L');
    ```

### Error "Cannot find template"

- Template PDF belum ada di `storage/app/templates/`
- Nama file salah
- Path tidak sesuai

## Testing

1. Upload template PDF ke `storage/app/templates/Format Formulir I'dad Tahfidz.pdf`
2. Login sebagai Panitia
3. Buka menu "Data Santri & PDF"
4. Klik tombol "PDF" (merah)
5. Download dan cek hasilnya
6. Sesuaikan koordinat jika perlu

---

**Note**: Untuk hasil terbaik, gunakan **fillable PDF form** dengan form fields yang sudah diberi nama sesuai data fields.
