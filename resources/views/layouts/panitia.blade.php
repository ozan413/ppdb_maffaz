<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Panitia') - PPDB Maskanul Huffadz</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --primary-gold: #B8860B;
            --secondary-gold: #D4AF37;
            --black: #1a1a1a;
            --dark-gray: #333333;
            --white: #FFFFFF;
            --off-white: #F8F9FA;
            --light-gray: #e9ecef;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--off-white);
            min-height: 100vh;
        }

        .dashboard-layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: 260px;
            background: var(--black);
            color: var(--white);
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }

        .sidebar-brand h2 { font-size: 1rem; font-weight: 600; }
        .sidebar-brand span { font-size: 0.7rem; opacity: 0.7; display: block; }

        .sidebar-menu { padding: 20px 0; list-style: none; }

        .sidebar-menu-title {
            padding: 10px 20px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.5;
        }

        .sidebar-menu li a {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: rgba(255,255,255,0.1);
            color: var(--white);
            border-left-color: var(--primary-gold);
        }

        .sidebar-menu li a i { width: 20px; text-align: center; }

        .main-content { flex: 1; margin-left: 260px; min-height: 100vh; }

        .top-header {
            background: var(--white);
            padding: 15px 30px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky; top: 0; z-index: 100;
        }

        .mobile-toggle {
            display: none;
            background: none; border: none;
            font-size: 1.3rem; cursor: pointer;
            color: var(--dark-gray);
        }

        .user-dropdown { display: flex; align-items: center; gap: 10px; }

        .user-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--white); font-weight: 600;
        }

        .user-info h4 { font-size: 0.9rem; color: var(--dark-gray); }
        .user-info span { font-size: 0.75rem; color: #999; }

        .content-area { padding: 30px; }

        .page-header { margin-bottom: 25px; }
        .page-header h1 { font-size: 1.5rem; color: var(--black); margin-bottom: 5px; }
        .page-header p { color: #666; font-size: 0.9rem; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px; margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            padding: 22px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .stat-card-icon {
            width: 45px; height: 45px;
            background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: var(--white); font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .stat-card h3 { font-size: 1.8rem; color: var(--black); margin-bottom: 5px; }
        .stat-card p { font-size: 0.85rem; color: #666; }

        .card {
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--light-gray);
            display: flex; justify-content: space-between; align-items: center;
        }

        .card-header h3 { font-size: 1rem; color: var(--black); }
        .card-body { padding: 25px; }

        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
            font-size: 0.9rem;
        }
        table th { background: var(--off-white); font-weight: 600; color: var(--dark-gray); }
        table tr:hover { background: rgba(184, 134, 11, 0.03); }

        .btn {
            padding: 10px 20px; border-radius: 8px;
            font-weight: 500; font-size: 0.9rem;
            text-decoration: none; transition: all 0.3s ease;
            cursor: pointer; border: none;
            display: inline-flex; align-items: center; gap: 8px;
            font-family: inherit;
        }
        .btn-primary { background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold)); color: var(--white); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(184, 134, 11, 0.3); }
        .btn-info { background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold)); color: var(--white); }
        .btn-secondary { background: var(--light-gray); color: var(--dark-gray); }
        .btn-success { background: #28a745; color: var(--white); }
        .btn-danger { background: #dc3545; color: var(--white); }
        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }

        .badge { padding: 4px 10px; border-radius: 50px; font-size: 0.75rem; font-weight: 500; }
        .badge-success { background: rgba(40, 167, 69, 0.1); color: #28a745; }
        .badge-warning { background: rgba(255, 193, 7, 0.1); color: #856404; }
        .badge-danger { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .badge-info { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
        .badge-primary { background: rgba(184, 134, 11, 0.1); color: var(--primary-gold); }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: var(--dark-gray); font-size: 0.9rem; }
        .form-control {
            width: 100%; padding: 12px 15px;
            border: 2px solid var(--light-gray);
            border-radius: 10px; font-size: 0.95rem;
            font-family: inherit; transition: all 0.3s ease;
        }
        .form-control:focus { outline: none; border-color: var(--primary-gold); box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1); }
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
        }
        .form-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }

        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: rgba(40, 167, 69, 0.1); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.2); }
        .alert-error { background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.2); }
        .alert-info { background: rgba(23, 162, 184, 0.1); color: #17a2b8; border: 1px solid rgba(23, 162, 184, 0.2); }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-toggle { display: block; }
            .form-row { grid-template-columns: 1fr; }
        }

        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; }
        .overlay.active { display: block; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="dashboard-layout">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon"><i class="fas fa-mosque"></i></div>
                <div>
                    <h2>Panel Panitia</h2>
                    <span>Maskanul Huffadz</span>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="sidebar-menu-title">Menu Utama</li>
                <li><a href="{{ route('panitia.dashboard') }}" class="{{ request()->routeIs('panitia.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="{{ route('panitia.pendaftar.index') }}" class="{{ request()->routeIs('panitia.pendaftar.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Data Pendaftar</a></li>

                <li class="sidebar-menu-title">Wawancara</li>
                <li><a href="{{ route('panitia.interview.index') }}" class="{{ request()->routeIs('panitia.interview.index') ? 'active' : '' }}"><i class="fas fa-calendar-plus"></i> Jadwalkan Wawancara</a></li>
                <li><a href="{{ route('panitia.interview.monitor') }}" class="{{ request()->routeIs('panitia.interview.monitor') ? 'active' : '' }}"><i class="fas fa-eye"></i> Monitor Wawancara</a></li>

                <li class="sidebar-menu-title">Kelulusan</li>
                <li><a href="{{ route('panitia.graduation.index') }}" class="{{ request()->routeIs('panitia.graduation.*') ? 'active' : '' }}"><i class="fas fa-trophy"></i> Keputusan Kelulusan</a></li>

                <li class="sidebar-menu-title">Data</li>
                <li><a href="{{ route('panitia.data-santri.index') }}" class="{{ request()->routeIs('panitia.data-santri.*') ? 'active' : '' }}"><i class="fas fa-file-pdf"></i> Data Santri & PDF</a></li>
                <li><a href="{{ route('panitia.keuangan.index') }}" class="{{ request()->routeIs('panitia.keuangan.*') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> Keuangan</a></li>
                <li><a href="{{ route('panitia.rekap-data.index') }}" class="{{ request()->routeIs('panitia.rekap-data.*') ? 'active' : '' }}"><i class="fas fa-file-excel"></i> Rekap Data & Excel</a></li>

                <li class="sidebar-menu-title">Akun</li>
                <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <button class="mobile-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <div class="user-dropdown">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <h4>{{ auth()->user()->name }}</h4>
                        <span>Panitia PPDB</span>
                    </div>
                </div>
            </header>

            <div class="content-area">
                @if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
                @if(session('error'))<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>@endif
                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Mohon perbaiki kesalahan berikut:</strong>
                            <ul style="list-style:none;margin:0;padding:0;">
                                @foreach($errors->all() as $error)
                                    <li style="margin-bottom:2px;font-size:0.85rem;">• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>

    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    <script>function toggleSidebar() { document.getElementById('sidebar').classList.toggle('active'); document.getElementById('overlay').classList.toggle('active'); }</script>
    @stack('scripts')
</body>
</html>
