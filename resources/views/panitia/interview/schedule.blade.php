@extends('layouts.panitia')

@section('title', 'Jadwalkan Wawancara')

@section('content')
<div class="page-header">
    <h1>Jadwalkan Wawancara</h1>
    <p>Daftar santri yang menunggu dijadwalkan wawancara</p>
</div>

<div class="card" style="margin-bottom: 20px;">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap;">
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
                            <th>Nama Santri</th>
                            <th>Program</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $reg)
                            <tr>
                                <td><strong>{{ $reg->user->name }}</strong><br><small style="color: #999;">{{ $reg->user->email }}</small></td>
                                <td>{{ $reg->program->name }}</td>
                                <td>{{ $reg->created_at->format('d M Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" onclick="openScheduleModal({{ $reg->id }}, '{{ $reg->user->name }}')">
                                        <i class="fas fa-calendar-plus"></i> Jadwalkan
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $registrations->links() }}
        @else
            <div style="text-align: center; padding: 50px; color: #999;">
                <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 15px;"></i>
                <p>Semua santri sudah dijadwalkan wawancara</p>
            </div>
        @endif
    </div>
</div>

<!-- Schedule Modal -->
<div id="scheduleModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1001; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 15px; max-width: 500px; width: 90%;">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-calendar-plus"></i> Jadwalkan Wawancara</h3>
        <p style="margin-bottom: 20px;">Santri: <strong id="modalSantriName"></strong></p>

        <form action="{{ route('panitia.interview.schedule') }}" method="POST">
            @csrf
            <input type="hidden" name="registration_id" id="modalRegistrationId">

            <div class="form-group">
                <label>Ustad Pewawancara <span style="color: red;">*</span></label>
                <select name="ustad_id" class="form-control" required>
                    <option value="">-- Pilih Ustad --</option>
                    @foreach($ustads as $ustad)
                        <option value="{{ $ustad->id }}">{{ $ustad->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal <span style="color: red;">*</span></label>
                    <input type="date" name="schedule_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Waktu <span style="color: red;">*</span></label>
                    <input type="time" name="schedule_time" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Media Wawancara <span style="color: red;">*</span></label>
                <select name="media" class="form-control" required>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="video_call">Video Call (Zoom/Meet)</option>
                    <option value="tatap_muka">Tatap Muka</option>
                </select>
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="button" class="btn btn-secondary" onclick="closeScheduleModal()">Batal</button>
                <button type="submit" class="btn btn-info" style="flex: 1;"><i class="fas fa-save"></i> Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openScheduleModal(regId, santriName) {
    document.getElementById('modalRegistrationId').value = regId;
    document.getElementById('modalSantriName').textContent = santriName;
    document.getElementById('scheduleModal').style.display = 'flex';
}

function closeScheduleModal() {
    document.getElementById('scheduleModal').style.display = 'none';
}
</script>
@endpush
@endsection
