<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - PPDB Maskanul Huffadz</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-gold: #B8860B;
            --secondary-gold: #D4AF37;
            --black: #1a1a1a;
            --dark-gray: #333333;
            --white: #FFFFFF;
            --off-white: #F8F9FA;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1000px;
            width: 100%;
            background: var(--white);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        }

        .register-visual {
            background: linear-gradient(135deg, var(--black) 0%, #2d2d2d 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .register-visual::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23B8860B' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .register-visual-content {
            position: relative;
            z-index: 1;
        }

        .register-visual-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 2.5rem;
        }

        .register-visual h2 {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .register-visual p {
            font-size: 1rem;
            opacity: 0.8;
            max-width: 300px;
            line-height: 1.7;
        }

        .register-steps {
            margin-top: 40px;
            text-align: left;
        }

        .register-step {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .step-number {
            width: 30px;
            height: 30px;
            background: rgba(184, 134, 11, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .step-text {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .register-form-section {
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-height: 100vh;
            overflow-y: auto;
        }

        .register-form-header {
            margin-bottom: 30px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--dark-gray);
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: var(--primary-gold);
        }

        .register-form-header h1 {
            font-size: 1.6rem;
            color: var(--black);
            margin-bottom: 8px;
        }

        .register-form-header p {
            color: #666;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: var(--dark-gray);
            font-size: 0.85rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-gold);
            box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1);
        }

        .form-hint {
            font-size: 0.75rem;
            color: #999;
            margin-top: 5px;
        }

        .btn {
            width: 100%;
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: inherit;
            margin-top: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
            color: var(--white);
            box-shadow: 0 4px 15px rgba(184, 134, 11, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(184, 134, 11, 0.4);
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 0.85rem;
        }

        .form-footer a {
            color: var(--primary-gold);
            text-decoration: none;
            font-weight: 600;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .error-list {
            list-style: none;
        }

        .error-list li {
            margin-bottom: 3px;
        }

        @media (max-width: 768px) {
            .register-container {
                grid-template-columns: 1fr;
            }

            .register-visual {
                display: none;
            }

            .register-form-section {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-visual">
            <div class="register-visual-content">
                <div class="register-visual-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2>Daftar PPDB</h2>
                <p>Bergabunglah dengan Maskanul Huffadz untuk memulai perjalanan menghafal Al-Quran.</p>

                <div class="register-steps">
                    <div class="register-step">
                        <span class="step-number">1</span>
                        <span class="step-text">Buat akun</span>
                    </div>
                    <div class="register-step">
                        <span class="step-number">2</span>
                        <span class="step-text">Pilih program</span>
                    </div>
                    <div class="register-step">
                        <span class="step-number">3</span>
                        <span class="step-text">Isi formulir</span>
                    </div>
                    <div class="register-step">
                        <span class="step-number">4</span>
                        <span class="step-text">Pembayaran</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-form-section">
            <div class="register-form-header">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
                <h1>Daftar Akun Baru</h1>
                <p>Isi data berikut untuk membuat akun santri</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-at"></i>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" value="{{ old('username') }}" required>
                    </div>
                    <p class="form-hint">Username hanya boleh berisi huruf, angka, strip, dan underscore</p>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email aktif" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </button>
            </form>

            <div class="form-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>
</html>
