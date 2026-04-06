@extends('layouts.santri')

@section('title', 'Pilih Program')

@section('content')
<div class="page-header">
    <h1>Pilih Program Pendaftaran</h1>
    <p>Silakan pilih program yang sesuai dengan kebutuhan Anda</p>
</div>

@if($registration && $registration->program_id)
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        Anda sudah memilih program <strong>{{ $registration->program->name }}</strong>. Klik "Lanjutkan" untuk mengisi formulir.
    </div>
@endif

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
    @foreach($programs as $program)
        <div class="card" style="border: 2px solid {{ $registration && $registration->program_id == $program->id ? 'var(--green-islamic)' : 'transparent' }};">
            <div class="card-body" style="text-align: center; padding: 30px;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold)); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.8rem;">
                    @if($program->slug == 'iddah-tahfidz')
                        <i class="fas fa-book-quran"></i>
                    @elseif($program->slug == 'lil-athfal')
                        <i class="fas fa-child"></i>
                    @else
                        <i class="fas fa-baby"></i>
                    @endif
                </div>
                
                <h3 style="margin-bottom: 10px; color: var(--black);">{{ $program->name }}</h3>
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 15px;">{{ $program->description ?? 'Program pendidikan Al-Quran berkualitas.' }}</p>
                
                @if($program->price > 0)
                    <div style="font-size: 1.3rem; font-weight: 700; color: var(--primary-gold); margin-bottom: 20px;">
                        Rp {{ number_format($program->price, 0, ',', '.') }}
                    </div>
                @else
                    <div style="font-size: 1rem; color: #666; margin-bottom: 20px;">
                        Biaya: Hubungi Admin
                    </div>
                @endif

                <form action="{{ route('santri.program.select') }}" method="POST">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $program->id }}">
                    
                    @if($registration && $registration->program_id == $program->id)
                        <a href="{{ route('santri.program.form', $program->slug) }}" class="btn btn-success" style="width: 100%;">
                            <i class="fas fa-arrow-right"></i> Lanjutkan Isi Formulir
                        </a>
                    @else
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-check"></i> Pilih Program Ini
                        </button>
                    @endif
                </form>
            </div>
        </div>
    @endforeach
</div>

@if($programs->isEmpty())
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 60px;">
            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
            <h3 style="color: #666;">Belum Ada Program Tersedia</h3>
            <p style="color: #999;">Silakan hubungi admin untuk informasi lebih lanjut.</p>
        </div>
    </div>
@endif
@endsection
