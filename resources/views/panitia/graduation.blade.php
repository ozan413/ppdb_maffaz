@extends('layouts.panitia')

@section('title', 'Keputusan Kelulusan')

@section('content')
<div class="page-header">
    <h1>Keputusan Kelulusan</h1>
    <p>Tentukan status kelulusan santri yang telah menyelesaikan wawancara</p>
</div>

<div class="card" style="margin-bottom: 20px;">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap;">
            <select name="decision" class="form-control" style="max-width: 200px;">
                <option value="">Semua</option>
                <option value="pending" {{ request('decision') == 'pending' ? 'selected' : '' }}>Menunggu Keputusan</option>
                <option value="passed" {{ request('decision') == 'passed' ? 'selected' : '' }}>Lulus</option>
                <option value="failed" {{ request('decision') == 'failed' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
            <select name="program_id" class="form-control" style="max-width: 200px;">
                <option value="">Semua Program</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-filter"></i> Filter</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($registrations->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Santri</th>
                            <th>Program</th>
                            <th style="text-align: center;">Akademik</th>
                            <th style="text-align: center;">Wawancara</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $reg)
                            <tr>
                                <td>
                                    <strong>{{ $reg->user->name }}</strong><br>
                                    <small style="color: #999;">{{ $reg->user->email }}</small>
                                </td>
                                <td>{{ $reg->program->name }}</td>
                                <td style="text-align: center;">
                                    @if($reg->interviewSchedule && $reg->interviewSchedule->result)
                                        <strong style="font-size: 1.2rem; color: #1565C0;">{{ $reg->interviewSchedule->result->nilai_akademik }}</strong>
                                        <br>
                                        <small style="color: #999;">
                                            T: {{ $reg->interviewSchedule->result->nilai_tahfidz ?? 0 }} |
                                            S: {{ $reg->interviewSchedule->result->nilai_tahsin ?? 0 }} |
                                            A: {{ $reg->interviewSchedule->result->nilai_bahasa_arab ?? 0 }} |
                                            J: {{ $reg->interviewSchedule->result->nilai_tajwid ?? 0 }}
                                        </small>
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($reg->interviewSchedule && $reg->interviewSchedule->result)
                                        <span class="badge" style="font-size: 1rem; padding: 8px 15px;
                                            @switch($reg->interviewSchedule->result->nilai_wawancara)
                                                @case('A') background: rgba(40, 167, 69, 0.15); color: #28a745; @break
                                                @case('B') background: rgba(23, 162, 184, 0.15); color: #17a2b8; @break
                                                @case('C') background: rgba(255, 193, 7, 0.15); color: #856404; @break
                                                @case('D') background: rgba(220, 53, 69, 0.15); color: #dc3545; @break
                                                @default background: #f0f0f0; color: #999; @break
                                            @endswitch
                                        ">{{ $reg->interviewSchedule->result->nilai_wawancara }}</span>
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($reg->graduationDecision)
                                        @if($reg->graduationDecision->is_lulus)
                                            <span class="badge badge-success">LULUS</span>
                                        @else
                                            <span class="badge badge-danger">TIDAK LULUS</span>
                                        @endif
                                    @else
                                        <span class="badge badge-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($reg->interviewSchedule && $reg->interviewSchedule->result)
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="showDetail({{ $reg->id }})" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @endif
                                    @if(!$reg->graduationDecision)
                                        <button type="button" class="btn btn-sm btn-success" onclick="openDecisionModal({{ $reg->id }}, '{{ $reg->user->name }}', true)">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="openDecisionModal({{ $reg->id }}, '{{ $reg->user->name }}', false)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $registrations->links() }}
        @else
            <div style="text-align: center; padding: 50px; color: #999;">
                <i class="fas fa-gavel" style="font-size: 3rem; margin-bottom: 15px;"></i>
                <p>Belum ada santri yang menunggu keputusan</p>
            </div>
        @endif
    </div>
</div>

<!-- Decision Modal -->
<div id="decisionModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1001; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 15px; max-width: 400px; width: 90%;">
        <h3 style="margin-bottom: 10px;" id="modalTitle">Konfirmasi Keputusan</h3>
        <p id="modalMessage" style="margin-bottom: 20px;"></p>

        <form id="decisionForm" method="POST">
            @csrf
            <input type="hidden" name="is_lulus" id="modalIsLulus">

            <div class="form-group">
                <label>Catatan (opsional)</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="button" class="btn btn-secondary" onclick="closeDecisionModal()">Batal</button>
                <button type="submit" class="btn" id="modalSubmitBtn" style="flex: 1;">Konfirmasi</button>
            </div>
        </form>
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
    color: #1565C0;
    font-size: 0.95rem;
}
</style>

@push('scripts')
<script>
const registrationData = @json($registrations->keyBy('id'));

function openDecisionModal(regId, santriName, isLulus) {
    document.getElementById('modalIsLulus').value = isLulus ? '1' : '0';
    document.getElementById('decisionForm').action = '/panitia/graduation/' + regId + '/decide';
    
    if (isLulus) {
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-check-circle" style="color: #28a745;"></i> Luluskan Santri';
        document.getElementById('modalMessage').textContent = 'Anda akan meluluskan ' + santriName + '. Lanjutkan?';
        document.getElementById('modalSubmitBtn').className = 'btn btn-success';
        document.getElementById('modalSubmitBtn').innerHTML = '<i class="fas fa-check"></i> Ya, Luluskan';
    } else {
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-times-circle" style="color: #dc3545;"></i> Tidak Luluskan Santri';
        document.getElementById('modalMessage').textContent = 'Anda akan tidak meluluskan ' + santriName + '. Lanjutkan?';
        document.getElementById('modalSubmitBtn').className = 'btn btn-danger';
        document.getElementById('modalSubmitBtn').innerHTML = '<i class="fas fa-times"></i> Ya, Tidak Luluskan';
    }
    
    document.getElementById('decisionModal').style.display = 'flex';
}

function closeDecisionModal() {
    document.getElementById('decisionModal').style.display = 'none';
}

function showDetail(regId) {
    const reg = registrationData[regId];
    if (!reg || !reg.interview_schedule || !reg.interview_schedule.result) {
        document.getElementById('detailContent').innerHTML = '<p style="text-align: center; color: #999;">Data tidak tersedia</p>';
        document.getElementById('detailModal').style.display = 'flex';
        return;
    }

    const result = reg.interview_schedule.result;
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
                <table style="width: 100%;">
                    <tr><td>Tahfidz</td><td style="text-align: right; font-weight: 600;">${result.nilai_tahfidz || 0}</td></tr>
                    <tr><td>Tahsin</td><td style="text-align: right; font-weight: 600;">${result.nilai_tahsin || 0}</td></tr>
                    <tr><td>Bahasa Arab</td><td style="text-align: right; font-weight: 600;">${result.nilai_bahasa_arab || 0}</td></tr>
                    <tr><td>Tajwid</td><td style="text-align: right; font-weight: 600;">${result.nilai_tajwid || 0}</td></tr>
                    <tr style="border-top: 2px solid #ddd;"><td><strong>Rata-rata</strong></td><td style="text-align: right; font-weight: 700; font-size: 1.2rem; color: #1565C0;">${avgAcademic.toFixed(2)}</td></tr>
                </table>
            </div>
            <div class="detail-section">
                <h4><i class="fas fa-clipboard-check"></i> Nilai Wawancara</h4>
                <table style="width: 100%;">
                    ${aspectsHtml}
                </table>
            </div>
        </div>
        <div class="detail-section" style="margin-top: 20px;">
            <h4><i class="fas fa-comment-dots"></i> Catatan Orang Tua</h4>
            <p style="margin: 0;">${result.catatan_orang_tua || '<em style="color: #999;">Tidak ada catatan</em>'}</p>
        </div>
        <div class="detail-section" style="margin-top: 15px;">
            <h4><i class="fas fa-pen"></i> Catatan Ustad</h4>
            <p style="margin: 0;">${result.catatan_ustad || '<em style="color: #999;">Tidak ada catatan</em>'}</p>
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
