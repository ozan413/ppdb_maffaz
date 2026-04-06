@extends('layouts.ustad')

@section('title', 'Detail Wawancara')

@section('content')
<div class="page-header">
    <h1>Wawancara Santri</h1>
    <p>Input nilai wawancara untuk {{ $schedule->registration->user->name }}</p>
</div>

@if(!$canEdit)
<div class="alert alert-info" style="background: rgba(220, 53, 69, 0.1); border-color: rgba(220, 53, 69, 0.2); color: #dc3545;">
    <i class="fas fa-lock"></i>
    <strong>Nilai Terkunci.</strong> Keputusan kelulusan sudah diberikan oleh panitia. Nilai tidak dapat diubah lagi.
</div>
@endif

<form action="{{ route('ustad.interview.store-result', $schedule->id) }}" method="POST">
    @csrf

    <div style="display: grid; grid-template-columns: 350px 1fr; gap: 20px;">
        <!-- Left: Santri Info -->
        <div>
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-user"></i> Data Santri</h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Nama</td>
                            <td style="padding: 8px 0;"><strong>{{ $schedule->registration->user->name }}</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Email</td>
                            <td style="padding: 8px 0;">{{ $schedule->registration->user->email }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Program</td>
                            <td style="padding: 8px 0;">{{ $schedule->registration->program->name }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Media</td>
                            <td style="padding: 8px 0;">
                                @switch($schedule->media)
                                    @case('whatsapp') WhatsApp @break
                                    @case('video_call') Video Call @break
                                    @case('tatap_muka') Tatap Muka @break
                                @endswitch
                            </td>
                        </tr>
                    </table>

                    @if($programData)
                        <hr style="margin: 20px 0;">
                        <h4 style="margin-bottom: 15px; font-size: 0.95rem;">Info Tambahan</h4>
                        <table style="width: 100%; font-size: 0.9rem;">
                            @if(isset($programData->tempat_lahir))
                                <tr>
                                    <td style="padding: 5px 0; color: #666;">TTL</td>
                                    <td style="padding: 5px 0;">{{ $programData->tempat_lahir }}, {{ $programData->tanggal_lahir }}</td>
                                </tr>
                            @endif
                            @if(isset($programData->pendidikan_terakhir))
                                <tr>
                                    <td style="padding: 5px 0; color: #666;">Pendidikan</td>
                                    <td style="padding: 5px 0;">{{ $programData->pendidikan_terakhir }}</td>
                                </tr>
                            @endif
                        </table>
                    @endif
                </div>
            </div>

            <!-- Nilai Akademik -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-graduation-cap"></i> Nilai Akademik</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nilai Tahfidz (0-100)</label>
                        <input type="number" name="nilai_tahfidz" class="form-control" min="0" max="100" value="{{ old('nilai_tahfidz', $schedule->result->nilai_tahfidz ?? '') }}" {{ !$canEdit ? 'disabled' : '' }}>
                    </div>

                    <div class="form-group">
                        <label>Nilai Tahsin (0-100)</label>
                        <input type="number" name="nilai_tahsin" class="form-control" min="0" max="100" value="{{ old('nilai_tahsin', $schedule->result->nilai_tahsin ?? '') }}" {{ !$canEdit ? 'disabled' : '' }}>
                    </div>

                    <div class="form-group">
                        <label>Nilai Bahasa Arab (0-100)</label>
                        <input type="number" name="nilai_bahasa_arab" class="form-control" min="0" max="100" value="{{ old('nilai_bahasa_arab', $schedule->result->nilai_bahasa_arab ?? '') }}" {{ !$canEdit ? 'disabled' : '' }}>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Nilai Tajwid (0-100)</label>
                        <input type="number" name="nilai_tajwid" class="form-control" min="0" max="100" value="{{ old('nilai_tajwid', $schedule->result->nilai_tajwid ?? '') }}" {{ !$canEdit ? 'disabled' : '' }}>
                    </div>

                    <div style="background: var(--off-white); padding: 15px; border-radius: 10px; margin-top: 20px; text-align: center;">
                        <small style="color: #666;">Rata-rata Akademik</small>
                        <p style="font-size: 1.5rem; font-weight: 700; color: var(--primary-gold); margin: 0;" id="avgAcademic">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Assessment Forms -->
        <div>
            <!-- Kriteria Penilaian Wawancara -->
            @if($criterias->count() > 0)
                @foreach($criterias as $criteria)
                    <div class="card">
                        <div class="card-header" style="background: rgba(0, 105, 92, 0.05);">
                            <h3><i class="fas fa-clipboard-check"></i> {{ $criteria->name }}</h3>
                        </div>
                        <div class="card-body">
                            @if($criteria->aspects->count() > 0)
                                <table style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 50%;">Aspek yang Dinilai</th>
                                            <th style="text-align: center; width: 12.5%;">A</th>
                                            <th style="text-align: center; width: 12.5%;">B</th>
                                            <th style="text-align: center; width: 12.5%;">C</th>
                                            <th style="text-align: center; width: 12.5%;">D</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($criteria->aspects as $aspect)
                                            <tr>
                                                <td style="padding: 12px 0;">{{ $aspect->name }}</td>
                                                <td style="text-align: center;">
                                                    <input type="radio" name="aspect_scores[{{ $aspect->id }}]" value="A" {{ ($existingScores[$aspect->id] ?? '') == 'A' ? 'checked' : '' }} {{ !$canEdit ? 'disabled' : '' }}>
                                                </td>
                                                <td style="text-align: center;">
                                                    <input type="radio" name="aspect_scores[{{ $aspect->id }}]" value="B" {{ ($existingScores[$aspect->id] ?? '') == 'B' ? 'checked' : '' }} {{ !$canEdit ? 'disabled' : '' }}>
                                                </td>
                                                <td style="text-align: center;">
                                                    <input type="radio" name="aspect_scores[{{ $aspect->id }}]" value="C" {{ ($existingScores[$aspect->id] ?? '') == 'C' ? 'checked' : '' }} {{ !$canEdit ? 'disabled' : '' }}>
                                                </td>
                                                <td style="text-align: center;">
                                                    <input type="radio" name="aspect_scores[{{ $aspect->id }}]" value="D" {{ ($existingScores[$aspect->id] ?? '') == 'D' ? 'checked' : '' }} {{ !$canEdit ? 'disabled' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="margin-top: 15px; padding: 10px; background: #f8f9fa; border-radius: 8px; font-size: 0.85rem; color: #666;">
                                    <strong>Keterangan:</strong> A = Sangat Baik, B = Baik, C = Cukup, D = Kurang
                                </div>
                            @else
                                <p style="color: #999; text-align: center;">Belum ada aspek untuk kriteria ini</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card">
                    <div class="card-body" style="text-align: center; padding: 40px; color: #999;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 15px;"></i>
                        <p>Kriteria penilaian belum dikonfigurasi.</p>
                        <small>Hubungi Admin untuk menambahkan kriteria penilaian.</small>
                    </div>
                </div>
            @endif

            <!-- Catatan Orang Tua -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-comment-dots"></i> Tanggapan Orang Tua</h3>
                </div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Catatan dari Orang Tua/Wali</label>
                        <textarea name="catatan_orang_tua" class="form-control" rows="4" placeholder="Tuliskan tanggapan orang tua/wali terkait pendaftaran anak mereka..." {{ !$canEdit ? 'disabled' : '' }}>{{ old('catatan_orang_tua', $schedule->result->catatan_orang_tua ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Catatan Ustad -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-pen"></i> Catatan Ustad</h3>
                </div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Catatan Tambahan</label>
                        <textarea name="catatan_ustad" class="form-control" rows="3" placeholder="Catatan atau komentar tambahan dari pewawancara..." {{ !$canEdit ? 'disabled' : '' }}>{{ old('catatan_ustad', $schedule->result->catatan_ustad ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 15px;">
                <a href="{{ route('ustad.interview.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                @if($canEdit)
                <button type="submit" class="btn btn-teal" style="flex: 1;">
                    <i class="fas fa-save"></i> Simpan Penilaian
                </button>
                @endif
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function calcAverage() {
    const tahfidz = parseInt(document.querySelector('input[name="nilai_tahfidz"]').value) || 0;
    const tahsin = parseInt(document.querySelector('input[name="nilai_tahsin"]').value) || 0;
    const bahasaArab = parseInt(document.querySelector('input[name="nilai_bahasa_arab"]').value) || 0;
    const avg = ((tahfidz + tahsin + bahasaArab) / 3).toFixed(2);
    document.getElementById('avgAcademic').textContent = avg;
}

document.querySelector('input[name="nilai_tahfidz"]').addEventListener('input', calcAverage);
document.querySelector('input[name="nilai_tahsin"]').addEventListener('input', calcAverage);
document.querySelector('input[name="nilai_bahasa_arab"]').addEventListener('input', calcAverage);

calcAverage();
</script>
@endpush
@endsection
