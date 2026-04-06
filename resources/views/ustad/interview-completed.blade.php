@extends('layouts.ustad')

@section('title', 'Wawancara Selesai')

@section('content')
<div class="page-header">
    <h1>Wawancara Selesai</h1>
    <p>Daftar wawancara yang sudah Anda selesaikan</p>
</div>

<div class="card">
    <div class="card-body">
        @if($schedules->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Santri</th>
                            <th>Program</th>
                            <th>Tanggal Wawancara</th>
                            <th style="text-align: center;">Nilai Akademik</th>
                            <th style="text-align: center;">Nilai Wawancara</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $index => $schedule)
                            <tr>
                                <td>{{ $schedules->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $schedule->registration->user->name }}</strong>
                                    <br><small style="color: #666;">{{ $schedule->registration->user->email }}</small>
                                </td>
                                <td>{{ $schedule->registration->program->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d M Y') }}</td>
                                <td style="text-align: center;">
                                    @if($schedule->result)
                                        <span style="font-size: 1.2rem; font-weight: 700; color: #1565C0;">
                                            {{ $schedule->result->nilai_akademik }}
                                        </span>
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($schedule->result)
                                        <span class="badge" style="font-size: 1rem; padding: 8px 15px;
                                            @switch($schedule->result->nilai_wawancara)
                                                @case('A') background: rgba(40, 167, 69, 0.15); color: #28a745; @break
                                                @case('B') background: rgba(23, 162, 184, 0.15); color: #17a2b8; @break
                                                @case('C') background: rgba(255, 193, 7, 0.15); color: #856404; @break
                                                @case('D') background: rgba(220, 53, 69, 0.15); color: #dc3545; @break
                                            @endswitch
                                        ">
                                            {{ $schedule->result->nilai_wawancara }}
                                        </span>
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="showDetail({{ $schedule->id }})">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                    @if(!$schedule->registration->graduationDecision)
                                    <a href="{{ route('ustad.interview.show', $schedule->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit Nilai
                                    </a>
                                    @else
                                    <span class="badge badge-secondary" style="padding: 6px 10px;">
                                        <i class="fas fa-lock"></i> Terkunci
                                    </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px;">
                {{ $schedules->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 60px; color: #999;">
                <i class="fas fa-clipboard-check" style="font-size: 3rem; margin-bottom: 20px;"></i>
                <h3 style="color: #666;">Belum Ada Wawancara Selesai</h3>
                <p>Wawancara yang telah Anda selesaikan akan muncul di sini.</p>
            </div>
        @endif
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 700px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0;"><i class="fas fa-file-alt"></i> Detail Penilaian</h3>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <div id="detailContent">
            <p style="text-align: center; color: #999;">Memuat...</p>
        </div>
    </div>
</div>

<style>
.modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 1001;
    display: flex;
    align-items: center;
    justify-content: center;
}
.modal-content {
    background: white;
    padding: 30px;
    border-radius: 15px;
    max-height: 90vh;
    overflow-y: auto;
    width: 90%;
}
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.detail-section {
    background: var(--off-white);
    padding: 20px;
    border-radius: 12px;
}
.detail-section h4 {
    margin: 0 0 15px 0;
    color: var(--teal);
    font-size: 0.95rem;
}
.detail-section table {
    width: 100%;
}
.detail-section table td {
    padding: 8px 0;
    border: none;
}
</style>

@push('scripts')
<script>
const scheduleData = @json($schedules->keyBy('id'));

function showDetail(id) {
    const schedule = scheduleData[id];
    if (!schedule || !schedule.result) {
        document.getElementById('detailContent').innerHTML = '<p style="text-align: center; color: #999;">Data tidak tersedia</p>';
        document.getElementById('detailModal').style.display = 'flex';
        return;
    }

    const result = schedule.result;
    const avgAcademic = ((result.nilai_tahfidz || 0) + (result.nilai_tahsin || 0) + (result.nilai_bahasa_arab || 0) + (result.nilai_tajwid || 0)) / 4;

    let aspectsHtml = '';
    if (result.aspect_scores && result.aspect_scores.length > 0) {
        result.aspect_scores.forEach(score => {
            const aspectName = score.aspect ? score.aspect.name : 'Aspek';
            aspectsHtml += `<tr><td>${aspectName}</td><td style="text-align: center; font-weight: 600;">${score.score}</td></tr>`;
        });
    } else {
        aspectsHtml = '<tr><td colspan="2" style="text-align: center; color: #999;">Tidak ada data aspek</td></tr>';
    }

    const html = `
        <div class="detail-grid">
            <div class="detail-section">
                <h4><i class="fas fa-graduation-cap"></i> Nilai Akademik</h4>
                <table>
                    <tr>
                        <td>Tahfidz</td>
                        <td style="text-align: right; font-weight: 600;">${result.nilai_tahfidz || 0}</td>
                    </tr>
                    <tr>
                        <td>Tahsin</td>
                        <td style="text-align: right; font-weight: 600;">${result.nilai_tahsin || 0}</td>
                    </tr>
                    <tr>
                        <td>Bahasa Arab</td>
                        <td style="text-align: right; font-weight: 600;">${result.nilai_bahasa_arab || 0}</td>
                    </tr>
                    <tr>
                        <td>Tajwid</td>
                        <td style="text-align: right; font-weight: 600;">${result.nilai_tajwid || 0}</td>
                    </tr>
                    <tr style="border-top: 2px solid #ddd;">
                        <td><strong>Rata-rata</strong></td>
                        <td style="text-align: right; font-weight: 700; font-size: 1.2rem; color: #1565C0;">${avgAcademic.toFixed(2)}</td>
                    </tr>
                </table>
            </div>
            <div class="detail-section">
                <h4><i class="fas fa-clipboard-check"></i> Nilai Wawancara</h4>
                <table>
                    ${aspectsHtml}
                </table>
            </div>
        </div>
        <div class="detail-section" style="margin-top: 20px;">
            <h4><i class="fas fa-comment-dots"></i> Catatan Orang Tua</h4>
            <p style="margin: 0; color: #333;">${result.catatan_orang_tua || '<em style="color: #999;">Tidak ada catatan</em>'}</p>
        </div>
        <div class="detail-section" style="margin-top: 15px;">
            <h4><i class="fas fa-pen"></i> Catatan Ustad</h4>
            <p style="margin: 0; color: #333;">${result.catatan_ustad || '<em style="color: #999;">Tidak ada catatan</em>'}</p>
        </div>
    `;

    document.getElementById('detailContent').innerHTML = html;
    document.getElementById('detailModal').style.display = 'flex';
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}
</script>
@endpush
@endsection
