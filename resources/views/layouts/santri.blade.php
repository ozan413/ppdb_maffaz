<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Santri') - PPDB Maskanul Huffadz</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --primary-gold: #B8860B;
            --secondary-gold: #D4AF37;
            --light-gold: #F5E6C8;
            --black: #1a1a1a;
            --dark-gray: #333333;
            --white: #FFFFFF;
            --off-white: #F8F9FA;
            --light-gray: #e9ecef;
            --green-islamic: #1B5E20;
            --light-green: #E8F5E9;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            min-height: 100vh;
        }

        .dashboard-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Light Sidebar for Santri */
        .sidebar {
            width: 260px;
            background: var(--white);
            color: var(--dark-gray);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            border-right: 1px solid var(--light-gray);
        }

        .sidebar-brand {
            padding: 25px 20px;
            border-bottom: 1px solid var(--light-gray);
            display: flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, var(--light-green) 0%, var(--off-white) 100%);
        }

        .sidebar-brand-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--green-islamic), #2E7D32);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.2rem;
        }

        .sidebar-brand h2 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--black);
        }

        .sidebar-brand span {
            font-size: 0.7rem;
            color: var(--green-islamic);
            display: block;
        }

        .sidebar-menu {
            padding: 20px 0;
            list-style: none;
        }

        .sidebar-menu-title {
            padding: 10px 20px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: var(--dark-gray);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: var(--light-green);
            color: var(--green-islamic);
            border-left-color: var(--green-islamic);
        }

        .sidebar-menu li a i {
            width: 20px;
            text-align: center;
            color: var(--primary-gold);
        }

        .sidebar-menu li a.active i,
        .sidebar-menu li a:hover i {
            color: var(--green-islamic);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
        }

        .top-header {
            background: var(--white);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: var(--dark-gray);
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--green-islamic), #2E7D32);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 600;
        }

        .user-info h4 {
            font-size: 0.9rem;
            color: var(--dark-gray);
        }

        .user-info span {
            font-size: 0.75rem;
            color: #999;
        }

        .content-area {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            font-size: 1.5rem;
            color: var(--black);
            margin-bottom: 5px;
        }

        .page-header p {
            color: #666;
            font-size: 0.9rem;
        }

        /* Cards */
        .welcome-card {
            background: linear-gradient(135deg, var(--green-islamic), #2E7D32);
            color: var(--white);
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .welcome-card h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            position: relative;
        }

        .welcome-card p {
            font-size: 0.95rem;
            opacity: 0.9;
            position: relative;
            max-width: 500px;
        }

        .status-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .status-card {
            background: var(--white);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary-gold);
        }

        .status-card h3 {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 8px;
        }

        .status-card .value {
            font-size: 1.1rem;
            color: var(--black);
            font-weight: 600;
        }

        .card {
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--light-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            font-size: 1rem;
            color: var(--black);
        }

        .card-body {
            padding: 25px;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
            color: var(--white);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(184, 134, 11, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--green-islamic), #2E7D32);
            color: var(--white);
        }

        .btn-secondary {
            background: var(--light-gray);
            color: var(--dark-gray);
        }

        .btn-lg {
            padding: 14px 28px;
            font-size: 1rem;
        }

        /* Badge */
        .badge {
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-success { background: rgba(27, 94, 32, 0.1); color: var(--green-islamic); }
        .badge-warning { background: rgba(255, 193, 7, 0.1); color: #856404; }
        .badge-danger { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .badge-info { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
        .badge-primary { background: rgba(184, 134, 11, 0.1); color: var(--primary-gold); }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--light-gray);
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--green-islamic);
            box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.1);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        /* Alert */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(27, 94, 32, 0.1);
            color: var(--green-islamic);
            border: 1px solid rgba(27, 94, 32, 0.2);
        }

        .alert-error {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .alert-info {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
            border: 1px solid rgba(23, 162, 184, 0.2);
        }

        .alert-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        /* Inline Validation Error Styles */
        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2);
        }

        .text-error {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 4px;
            display: block;
        }

        .error-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .error-list li {
            margin-bottom: 2px;
            font-size: 0.85rem;
        }

        .error-list li::before {
            content: '•';
            margin-right: 6px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="dashboard-layout">
        <!-- Light Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-mosque"></i>
                </div>
                <div>
                    <h2>Portal Santri</h2>
                    <span>Maskanul Huffadz</span>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="sidebar-menu-title">Menu Utama</li>
                <li>
                    <a href="{{ route('santri.dashboard') }}" class="{{ request()->routeIs('santri.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('santri.program.index') }}" class="{{ request()->routeIs('santri.program.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i> Pendaftaran
                    </a>
                </li>
                <li>
                    <a href="{{ route('santri.biodata.index') }}" class="{{ request()->routeIs('santri.biodata.*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i> Biodata
                    </a>
                </li>

                <li class="sidebar-menu-title">Status</li>
                <li>
                    <a href="{{ route('santri.jadwal-wawancara') }}" class="{{ request()->routeIs('santri.jadwal-wawancara') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i> Jadwal Wawancara
                    </a>
                </li>
                <li>
                    <a href="{{ route('santri.pengumuman') }}" class="{{ request()->routeIs('santri.pengumuman') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i> Pengumuman
                    </a>
                </li>
                <li>
                    <a href="{{ route('santri.daftar-ulang') }}" class="{{ request()->routeIs('santri.daftar-ulang') ? 'active' : '' }}">
                        <i class="fas fa-redo"></i> Daftar Ulang
                    </a>
                </li>

                <li class="sidebar-menu-title">Akun</li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="user-dropdown">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <h4>{{ auth()->user()->name }}</h4>
                        <span>Santri</span>
                    </div>
                </div>
            </header>

            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        {{ session('info') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Mohon perbaiki kesalahan berikut:</strong>
                            <ul class="error-list">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
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

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }
    </script>
    @stack('scripts')
</body>
</html>
