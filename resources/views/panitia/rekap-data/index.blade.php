@extends('layouts.panitia')

@section('title', 'Rekap Data Santri')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Rekap Data Santri</h1>
            <p>Data lengkap santri yang sudah diputuskan kelulusannya</p>
        </div>
        <button type="button" onclick="exportToSpreadsheet()" class="btn btn-success">
            <i class="fab fa-google-drive"></i> Export ke Spreadsheet
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px;">
    <div class="card" style="background: linear-gradient(135deg, #1565C0, #1976D2);">
        <div class="card-body" style="color: white; text-align: center; padding: 25px;">
            <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 2.5rem;">{{ $stats['total'] }}</h2>
            <p style="margin: 5px 0 0; opacity: 0.9;">Total Diputuskan</p>
        </div>
    </div>
    <div class="card" style="background: linear-gradient(135deg, #28a745, #20c997);">
        <div class="card-body" style="color: white; text-align: center; padding: 25px;">
            <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 2.5rem;">{{ $stats['lulus'] }}</h2>
            <p style="margin: 5px 0 0; opacity: 0.9;">LULUS</p>
        </div>
    </div>
    <div class="card" style="background: linear-gradient(135deg, #dc3545, #fd7e14);">
        <div class="card-body" style="color: white; text-align: center; padding: 25px;">
            <i class="fas fa-times-circle" style="font-size: 2rem; margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 2.5rem;">{{ $stats['tidak_lulus'] }}</h2>
            <p style="margin: 5px 0 0; opacity: 0.9;">TIDAK LULUS</p>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom: 20px;">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 180px;">
                <label style="font-size: 0.85rem; color: #666;">Cari Nama</label>
                <input type="text" name="search" class="form-control" placeholder="Nama santri..." value="{{ request('search') }}">
            </div>
            <div style="min-width: 150px;">
                <label style="font-size: 0.85rem; color: #666;">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua</option>
                    <option value="lulus" {{ request('status') === 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="tidak_lulus" {{ request('status') === 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                </select>
            </div>
            <div style="min-width: 150px;">
                <label style="font-size: 0.85rem; color: #666;">Program</label>
                <select name="program_id" class="form-control">
                    <option value="">Semua</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-teal"><i class="fas fa-filter"></i> Filter</button>
            <a href="{{ route('panitia.rekap-data.index') }}" class="btn btn-secondary"><i class="fas fa-undo"></i> Reset</a>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-table"></i> Data Santri</h3>
        <span class="badge badge-info">{{ $registrations->total() }} data</span>
    </div>
    <div class="card-body" style="padding: 0;">
        @if($registrations->count() > 0)
            <div class="table-responsive">
                <table style="font-size: 0.85rem;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Program</th>
                            <th>Kelulusan</th>
                            <th>Nilai Akademik</th>
                            <th>Aspek Wawancara</th>
                            <th>Pembayaran</th>
                            <th>Daftar Ulang</th>
                            <th style="text-align: center;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $index => $reg)
                            @php
                                $result = $reg->interviewSchedule?->result;
                                $avgAcademic = 0;
                                if ($result) {
                                    $avgAcademic = (($result->nilai_tahfidz ?? 0) + ($result->nilai_tahsin ?? 0) + ($result->nilai_bahasa_arab ?? 0) + ($result->nilai_tajwid ?? 0)) / 4;
                                }
                            @endphp
                            <tr>
                                <td>{{ $registrations->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $reg->user->name }}</strong>
                                    <br><small style="color: #666;">{{ $reg->user->email }}</small>
                                </td>
                                <td><span class="badge badge-primary">{{ $reg->program->name }}</span></td>
                                <td>
                                    @if($reg->graduationDecision?->is_lulus)
                                        <span class="badge badge-success"><i class="fas fa-check"></i> LULUS</span>
                                    @else
                                        <span class="badge badge-danger"><i class="fas fa-times"></i> TIDAK LULUS</span>
                                    @endif
                                </td>
                                <td>
                                    @if($result)
                                        <div style="font-size: 0.8rem;">
                                            <span title="Tahfidz">T: {{ $result->nilai_tahfidz ?? '-' }}</span> |
                                            <span title="Tahsin">S: {{ $result->nilai_tahsin ?? '-' }}</span> |
                                            <span title="Bahasa Arab">A: {{ $result->nilai_bahasa_arab ?? '-' }}</span> |
                                            <span title="Tajwid">J: {{ $result->nilai_tajwid ?? '-' }}</span>
                                        </div>
                                        <strong style="color: var(--primary-gold);">Avg: {{ number_format($avgAcademic, 1) }}</strong>
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($result && $result->aspectScores->count() > 0)
                                        <div style="display: flex; flex-wrap: wrap; gap: 3px;">
                                            @foreach($result->aspectScores->take(4) as $score)
                                                <span class="badge" style="font-size: 0.7rem; padding: 3px 6px;
                                                    @switch($score->score)
                                                        @case('A') background: rgba(40, 167, 69, 0.15); color: #28a745; @break
                                                        @case('B') background: rgba(23, 162, 184, 0.15); color: #17a2b8; @break
                                                        @case('C') background: rgba(255, 193, 7, 0.15); color: #856404; @break
                                                        @case('D') background: rgba(220, 53, 69, 0.15); color: #dc3545; @break
                                                    @endswitch
                                                ">{{ $score->score }}</span>
                                            @endforeach
                                            @if($result->aspectScores->count() > 4)
                                                <span style="color: #999; font-size: 0.7rem;">+{{ $result->aspectScores->count() - 4 }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($reg->payment_status === 'paid')
                                        <span class="badge badge-success" style="font-size: 0.7rem;">LUNAS</span>
                                        @if($reg->payment)
                                            <br><small>Rp {{ number_format($reg->payment->amount ?? 0, 0, ',', '.') }}</small>
                                        @endif
                                    @else
                                        <span class="badge badge-warning" style="font-size: 0.7rem;">PENDING</span>
                                    @endif
                                </td>
                                <td>
                                    @if($reg->daftarUlangData)
                                        <span class="badge badge-success" style="font-size: 0.7rem;"><i class="fas fa-check"></i> Ada</span>
                                    @else
                                        <span style="color: #999; font-size: 0.8rem;">Belum</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="showDetail({{ $reg->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding: 20px;">
                {{ $registrations->appends(request()->query())->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 60px; color: #999;">
                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 20px;"></i>
                <h3 style="color: #666;">Belum Ada Data</h3>
                <p>Santri yang sudah diputuskan kelulusannya akan muncul di sini.</p>
            </div>
        @endif
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 800px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
            <h3 style="margin: 0;"><i class="fas fa-user"></i> Detail Data Santri</h3>
            <button type="button" onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <div id="modalContent">
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
    padding: 25px;
    border-radius: 15px;
    max-height: 90vh;
    overflow-y: auto;
    width: 95%;
}
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}
.detail-box {
    background: var(--off-white);
    padding: 15px;
    border-radius: 10px;
}
.detail-box h4 {
    margin: 0 0 10px;
    font-size: 0.9rem;
    color: var(--teal);
}
.detail-box p {
    margin: 5px 0;
    font-size: 0.85rem;
}
.detail-box .label {
    color: #666;
    display: inline-block;
    width: 100px;
}
</style>

@push('scripts')
<script>
const registrationData = @json($registrations->keyBy('id'));

function showDetail(id) {
    const reg = registrationData[id];
    if (!reg) {
        document.getElementById('modalContent').innerHTML = '<p style="text-align: center; color: #999;">Data tidak ditemukan</p>';
        document.getElementById('detailModal').style.display = 'flex';
        return;
    }

    const pd = reg.program_data || {};
    const result = reg.interview_schedule?.result || {};
    const du = reg.daftar_ulang_data || {};
    const avgAcademic = ((result.nilai_tahfidz || 0) + (result.nilai_tahsin || 0) + (result.nilai_bahasa_arab || 0) + (result.nilai_tajwid || 0)) / 4;

    const html = `
        <div class="detail-grid">
            <div class="detail-box">
                <h4><i class="fas fa-user"></i> Data Akun</h4>
                <p><span class="label">Nama:</span> <strong>${reg.user?.name || '-'}</strong></p>
                <p><span class="label">Email:</span> ${reg.user?.email || '-'}</p>
                <p><span class="label">Program:</span> ${reg.program?.name || '-'}</p>
            </div>
            <div class="detail-box">
                <h4><i class="fas fa-trophy"></i> Kelulusan</h4>
                <p><span class="label">Status:</span> <strong style="color: ${reg.graduation_decision?.is_lulus ? '#28a745' : '#dc3545'}">${reg.graduation_decision?.is_lulus ? 'LULUS' : 'TIDAK LULUS'}</strong></p>
                <p><span class="label">Catatan:</span> ${reg.graduation_decision?.notes || '-'}</p>
            </div>
            <div class="detail-box">
                <h4><i class="fas fa-id-card"></i> Biodata</h4>
                <p><span class="label">Nama:</span> ${pd.nama_lengkap || '-'}</p>
                <p><span class="label">TTL:</span> ${pd.tempat_lahir || '-'}, ${pd.tanggal_lahir || '-'}</p>
                <p><span class="label">Gender:</span> ${pd.gender || '-'}</p>
                <p><span class="label">No HP:</span> ${pd.no_hp || '-'}</p>
            </div>
            <div class="detail-box">
                <h4><i class="fas fa-graduation-cap"></i> Nilai Akademik</h4>
                <p><span class="label">Tahfidz:</span> ${result.nilai_tahfidz || '-'}</p>
                <p><span class="label">Tahsin:</span> ${result.nilai_tahsin || '-'}</p>
                <p><span class="label">B. Arab:</span> ${result.nilai_bahasa_arab || '-'}</p>
                <p><span class="label">Tajwid:</span> ${result.nilai_tajwid || '-'}</p>
                <p><span class="label">Rata-rata:</span> <strong style="color: var(--primary-gold);">${avgAcademic.toFixed(2)}</strong></p>
            </div>
            <div class="detail-box">
                <h4><i class="fas fa-credit-card"></i> Pembayaran</h4>
                <p><span class="label">Status:</span> ${reg.payment_status === 'paid' ? '<span style="color:#28a745">LUNAS</span>' : '<span style="color:#ffc107">PENDING</span>'}</p>
                <p><span class="label">Jumlah:</span> ${reg.payment ? 'Rp ' + new Intl.NumberFormat('id-ID').format(reg.payment.amount || 0) : '-'}</p>
            </div>
            <div class="detail-box">
                <h4><i class="fas fa-clipboard-check"></i> Daftar Ulang</h4>
                <p><span class="label">NIK:</span> ${du.nik || '-'}</p>
                <p><span class="label">NISN:</span> ${du.nisn || '-'}</p>
                <p><span class="label">Jubah:</span> ${du.ukuran_jubah || '-'}</p>
            </div>
        </div>
    `;

    document.getElementById('modalContent').innerHTML = html;
    document.getElementById('detailModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('detailModal').style.display = 'none';
}

// Export to Google Spreadsheet
async function exportToSpreadsheet() {
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    btn.disabled = true;

    try {
        // Get current filter params
        const params = new URLSearchParams(window.location.search);
        const response = await fetch(`{{ route('panitia.rekap-data.export') }}?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();
        
        if (result.success) {
            // Copy data to clipboard
            await navigator.clipboard.writeText(result.data);
            
            // Show success modal
            showExportModal(result.total, result.date);
        } else {
            alert('Gagal mengekspor data');
        }
    } catch (error) {
        console.error('Export error:', error);
        alert('Terjadi kesalahan saat mengekspor data');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

function showExportModal(total, date) {
    const modalHtml = `
        <div id="exportModal" class="modal" style="display: flex;">
            <div class="modal-content" style="max-width: 500px; text-align: center;">
                <div style="font-size: 4rem; color: #28a745; margin-bottom: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 style="margin-bottom: 15px;">Data Berhasil Dicopy!</h3>
                <p style="color: #666; margin-bottom: 20px;">
                    <strong>${total} data</strong> santri telah dicopy ke clipboard.<br>
                    Export: ${date}
                </p>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                    <p style="margin: 0 0 10px; font-size: 0.9rem; color: #666;">Langkah selanjutnya:</p>
                    <ol style="text-align: left; margin: 0; padding-left: 20px; font-size: 0.9rem;">
                        <li>Klik tombol di bawah untuk buka Google Sheets baru</li>
                        <li>Klik di cell A1</li>
                        <li>Tekan <strong>Ctrl+V</strong> untuk paste data</li>
                    </ol>
                </div>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button onclick="closeExportModal()" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                    <a href="https://docs.google.com/spreadsheets/create" target="_blank" class="btn btn-success" onclick="closeExportModal()">
                        <i class="fab fa-google-drive"></i> Buka Google Sheets
                    </a>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHtml);
}

function closeExportModal() {
    const modal = document.getElementById('exportModal');
    if (modal) modal.remove();
}
</script>
@endpush
@endsection
