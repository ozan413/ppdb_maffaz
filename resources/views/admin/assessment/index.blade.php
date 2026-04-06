@extends('layouts.admin')

@section('title', 'Pengaturan Penilaian')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <div>
        <h1>Pengaturan Penilaian</h1>
        <p>Kelola kriteria dan aspek penilaian wawancara</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <form method="GET" style="display: flex; gap: 10px;">
            <select name="year" class="form-control" onchange="this.form.submit()">
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ $academicYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </form>
        <button type="button" class="btn btn-secondary" onclick="openCopyModal()">
            <i class="fas fa-copy"></i> Salin ke Tahun Lain
        </button>
        <button type="button" class="btn btn-primary" onclick="openAddCriteriaModal()">
            <i class="fas fa-plus"></i> Tambah Kriteria
        </button>
    </div>
</div>

<div class="alert alert-info" style="margin-bottom: 20px;">
    <i class="fas fa-info-circle"></i>
    <strong>Catatan:</strong> Kriteria dan aspek penilaian ini akan digunakan oleh Ustad saat melakukan wawancara.
    Nilai yang tersedia: <strong>Sangat Baik</strong>, <strong>Baik</strong>, <strong>Cukup</strong>, <strong>Kurang</strong>.
</div>

@if($criterias->count() > 0)
    <div style="display: grid; gap: 20px;">
        @foreach($criterias as $criteria)
            <div class="card" style="border-left: 4px solid {{ $criteria->is_active ? 'var(--primary-gold)' : '#ccc' }};">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-clipboard-list"></i>
                        {{ $criteria->name }}
                        @if(!$criteria->is_active)
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </h3>
                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="btn btn-sm btn-success" onclick="openAddAspectModal({{ $criteria->id }}, '{{ $criteria->name }}')">
                            <i class="fas fa-plus"></i> Aspek
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="openEditCriteriaModal({{ $criteria->id }}, '{{ $criteria->name }}', {{ $criteria->is_active ? 'true' : 'false' }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.assessment.criteria.destroy', $criteria->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kriteria ini beserta semua aspeknya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if($criteria->aspects->count() > 0)
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Nama Aspek</th>
                                        <th style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($criteria->aspects as $index => $aspect)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $aspect->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="openEditAspectModal({{ $aspect->id }}, '{{ addslashes($aspect->name) }}')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.assessment.aspect.destroy', $aspect->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus aspek ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p style="color: #999; text-align: center; padding: 20px;">
                            <i class="fas fa-list"></i> Belum ada aspek. Klik "Aspek" untuk menambahkan.
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 60px;">
            <i class="fas fa-clipboard-list" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
            <h3 style="color: #666;">Belum Ada Kriteria</h3>
            <p style="color: #999;">Klik tombol "Tambah Kriteria" untuk mulai membuat kriteria penilaian.</p>
        </div>
    </div>
@endif

<!-- Add Criteria Modal -->
<div id="addCriteriaModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3><i class="fas fa-plus"></i> Tambah Kriteria Penilaian</h3>
        <form action="{{ route('admin.assessment.criteria.store') }}" method="POST">
            @csrf
            <input type="hidden" name="academic_year" value="{{ $academicYear }}">
            <div class="form-group">
                <label>Nama Kriteria <span style="color: red;">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="contoh: Adab & Akhlak" required>
            </div>
            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addCriteriaModal')">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex: 1;"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Criteria Modal -->
<div id="editCriteriaModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3><i class="fas fa-edit"></i> Edit Kriteria</h3>
        <form id="editCriteriaForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nama Kriteria <span style="color: red;">*</span></label>
                <input type="text" name="name" id="editCriteriaName" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="is_active" id="editCriteriaActive" class="form-control">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>
            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editCriteriaModal')">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex: 1;"><i class="fas fa-save"></i> Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Aspect Modal -->
<div id="addAspectModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3><i class="fas fa-plus"></i> Tambah Aspek</h3>
        <p style="color: #666; margin-bottom: 20px;">Kriteria: <strong id="aspectCriteriaName"></strong></p>
        <form action="{{ route('admin.assessment.aspect.store') }}" method="POST">
            @csrf
            <input type="hidden" name="criteria_id" id="aspectCriteriaId">
            <div class="form-group">
                <label>Nama Aspek <span style="color: red;">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="contoh: Sopan santun" required>
            </div>
            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addAspectModal')">Batal</button>
                <button type="submit" class="btn btn-success" style="flex: 1;"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Aspect Modal -->
<div id="editAspectModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3><i class="fas fa-edit"></i> Edit Aspek</h3>
        <form id="editAspectForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nama Aspek <span style="color: red;">*</span></label>
                <input type="text" name="name" id="editAspectName" class="form-control" required>
            </div>
            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editAspectModal')">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex: 1;"><i class="fas fa-save"></i> Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Copy to Year Modal -->
<div id="copyModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3><i class="fas fa-copy"></i> Salin Kriteria ke Tahun Lain</h3>
        <form action="{{ route('admin.assessment.copy') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Dari Tahun</label>
                <input type="text" name="from_year" value="{{ $academicYear }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Ke Tahun <span style="color: red;">*</span></label>
                <input type="text" name="to_year" class="form-control" placeholder="contoh: 2025/2026" required>
            </div>
            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('copyModal')">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex: 1;"><i class="fas fa-copy"></i> Salin</button>
            </div>
        </form>
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
    max-width: 500px;
    width: 90%;
}
</style>

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
function openAddCriteriaModal() {
    openModal('addCriteriaModal');
}
function openEditCriteriaModal(id, name, isActive) {
    document.getElementById('editCriteriaForm').action = '/admin/assessment/criteria/' + id;
    document.getElementById('editCriteriaName').value = name;
    document.getElementById('editCriteriaActive').value = isActive ? '1' : '0';
    openModal('editCriteriaModal');
}
function openAddAspectModal(criteriaId, criteriaName) {
    document.getElementById('aspectCriteriaId').value = criteriaId;
    document.getElementById('aspectCriteriaName').textContent = criteriaName;
    openModal('addAspectModal');
}
function openEditAspectModal(id, name) {
    document.getElementById('editAspectForm').action = '/admin/assessment/aspect/' + id;
    document.getElementById('editAspectName').value = name;
    openModal('editAspectModal');
}
function openCopyModal() {
    openModal('copyModal');
}
</script>
@endpush
@endsection
