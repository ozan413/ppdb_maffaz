<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->title ?? 'PPDB Maskanul Huffadz' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-gold: #B8860B;
            --secondary-gold: #D4AF37;
            --light-gold: #F5E6C8;
            --black: #1a1a1a;
            --dark-gray: #333333;
            --white: #FFFFFF;
            --off-white: #F8F9FA;
            --green-islamic: #1B5E20;
            --gradient-gold: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #F5E6C8 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; color: var(--dark-gray); line-height: 1.6; background: var(--white); overflow-x: hidden; }
        .arabic-font { font-family: 'Amiri', serif; }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(-45deg, #f5f7fa, #e8e8e8, #f0f4f8, #e4e8ec);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        .particle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: var(--primary-gold);
            opacity: 0.3;
            border-radius: 50%;
            animation: floatParticle 20s infinite;
        }
        @keyframes floatParticle {
            0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.3; }
            90% { opacity: 0.3; }
            100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .navbar.scrolled { background: rgba(255, 255, 255, 0.98); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15); }
        .navbar-container { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; height: 80px; }
        .navbar-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--black); }
        .navbar-brand img { height: 50px; width: auto; }
        .navbar-brand-text h1 { font-size: 1.2rem; font-weight: 700; background: var(--gradient-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .navbar-brand-text span { font-size: 0.75rem; color: var(--dark-gray); font-weight: 500; }
        .navbar-menu { display: flex; align-items: center; gap: 30px; list-style: none; }
        .navbar-menu a { text-decoration: none; color: var(--dark-gray); font-weight: 500; font-size: 0.95rem; transition: all 0.3s ease; position: relative; }
        .navbar-menu a:hover { color: var(--primary-gold); }
        .navbar-menu a::after { content: ''; position: absolute; bottom: -5px; left: 0; width: 0; height: 2px; background: var(--gradient-gold); transition: width 0.3s ease; }
        .navbar-menu a:hover::after { width: 100%; }
        .navbar-buttons { display: flex; gap: 12px; }

        .btn { padding: 12px 28px; border-radius: 50px; font-weight: 600; font-size: 0.9rem; text-decoration: none; transition: all 0.3s ease; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 8px; position: relative; overflow: hidden; }
        .btn::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); transition: left 0.5s; }
        .btn:hover::before { left: 100%; }
        .btn-outline { background: transparent; border: 2px solid var(--black); color: var(--black); }
        .btn-outline:hover { background: var(--black); color: var(--white); transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .btn-primary { background: var(--gradient-gold); color: var(--white); border: none; box-shadow: 0 6px 20px rgba(184, 134, 11, 0.4); }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 40px rgba(184, 134, 11, 0.5); }
        .mobile-menu-btn { display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--black); }

        /* Hero Section */
        .hero { min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; padding-top: 80px; background: linear-gradient(135deg, #f8f9fa 0%, #e8eef5 100%); }
        .hero-pattern { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23B8860B' fill-opacity='0.05'%3E%3Cpath d='M50 50c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10s-10-4.477-10-10 4.477-10 10-10zM10 10c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S0 25.523 0 20s4.477-10 10-10zm10 8c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm40 40c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); opacity: 0.8; }
        .hero-container { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; position: relative; z-index: 2; }
        .hero-content { animation: fadeInUp 1s ease; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

        .hero-badge { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 50px; font-size: 0.9rem; font-weight: 600; margin-bottom: 25px; animation: pulse 2s infinite; }
        .hero-badge.open { background: linear-gradient(135deg, rgba(27, 94, 32, 0.15), rgba(76, 175, 80, 0.15)); color: var(--green-islamic); border: 1px solid rgba(27, 94, 32, 0.3); }
        .hero-badge.closed { background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.3); }
        @keyframes pulse { 0%, 100% { box-shadow: 0 0 0 0 rgba(27, 94, 32, 0.4); } 50% { box-shadow: 0 0 0 10px rgba(27, 94, 32, 0); } }

        .hero-title { font-size: 3.8rem; font-weight: 800; color: var(--black); line-height: 1.1; margin-bottom: 25px; }
        .hero-title span { background: var(--gradient-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-subtitle { font-size: 1.2rem; color: #666; margin-bottom: 35px; max-width: 500px; line-height: 1.8; }
        .hero-buttons { display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 50px; }

        /* Stats Counter */
        .hero-stats { display: flex; gap: 40px; }
        .stat-item { text-align: center; }
        .stat-number { font-size: 2.5rem; font-weight: 800; background: var(--gradient-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .stat-label { font-size: 0.85rem; color: #666; font-weight: 500; }

        .hero-visual { position: relative; display: flex; justify-content: center; align-items: center; }
        .hero-image-wrapper { position: relative; width: 100%; max-width: 550px; }
        .hero-mosque { width: 100%; height: auto; border-radius: 30px; box-shadow: 0 40px 80px rgba(0, 0, 0, 0.2); transition: transform 0.5s ease; }
        .hero-image-wrapper:hover .hero-mosque { transform: scale(1.02); }

        /* Glassmorphism Cards */
        .glass-card { background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(20px); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.3); padding: 20px 25px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); }
        .floating-card { position: absolute; animation: float 4s ease-in-out infinite; }
        .floating-card.card-1 { top: 5%; right: -20px; animation-delay: 0s; }
        .floating-card.card-2 { bottom: 15%; left: -20px; animation-delay: 2s; }
        .floating-card.card-3 { top: 40%; right: -40px; animation-delay: 1s; }
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-15px) rotate(2deg); } }
        .floating-card i { font-size: 1.8rem; color: var(--primary-gold); margin-bottom: 8px; display: block; }
        .floating-card h4 { font-size: 1rem; color: var(--black); font-weight: 600; }
        .floating-card p { font-size: 0.8rem; color: #666; }

        /* Section Styles */
        .section { padding: 100px 20px; position: relative; }
        .section-container { max-width: 1280px; margin: 0 auto; }
        .section-header { text-align: center; margin-bottom: 60px; }
        .section-badge { display: inline-block; background: linear-gradient(135deg, rgba(184, 134, 11, 0.15), rgba(212, 175, 55, 0.15)); color: var(--primary-gold); padding: 10px 25px; border-radius: 50px; font-size: 0.9rem; font-weight: 600; margin-bottom: 20px; border: 1px solid rgba(184, 134, 11, 0.2); }
        .section-title { font-size: 2.8rem; font-weight: 800; color: var(--black); margin-bottom: 15px; }
        .section-subtitle { font-size: 1.1rem; color: #666; max-width: 600px; margin: 0 auto; }

        /* About Section */
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
        .about-image { border-radius: 30px; overflow: hidden; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15); position: relative; }
        .about-image::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, rgba(184, 134, 11, 0.2), transparent); z-index: 1; }
        .about-image img { width: 100%; height: 500px; object-fit: cover; display: block; transition: transform 0.5s ease; }
        .about-image:hover img { transform: scale(1.05); }
        .about-content h3 { font-size: 2.2rem; color: var(--black); margin-bottom: 20px; font-weight: 700; }
        .about-content p { color: #666; margin-bottom: 30px; line-height: 1.9; font-size: 1.05rem; }
        .about-features { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .about-feature { display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: var(--off-white); border-radius: 15px; transition: all 0.3s ease; }
        .about-feature:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1); }
        .about-feature i { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: var(--gradient-gold); color: var(--white); border-radius: 15px; flex-shrink: 0; font-size: 1.2rem; }
        .about-feature div h4 { font-size: 1rem; color: var(--black); margin-bottom: 5px; font-weight: 600; }
        .about-feature div p { font-size: 0.85rem; color: #888; margin: 0; }

        /* Programs Section */
        .programs-section { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%); color: var(--white); position: relative; overflow: hidden; }
        .programs-section::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23B8860B' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .programs-section .section-badge { background: rgba(184, 134, 11, 0.2); border-color: rgba(184, 134, 11, 0.3); }
        .programs-section .section-title { color: var(--white); }
        .programs-section .section-subtitle { color: rgba(255, 255, 255, 0.7); }
        .programs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; position: relative; z-index: 2; }

        .program-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 25px; padding: 45px 35px; text-align: center; transition: all 0.5s ease; position: relative; overflow: hidden; }
        .program-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--gradient-gold); transform: scaleX(0); transition: transform 0.5s ease; }
        .program-card::after { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at center, rgba(184, 134, 11, 0.1), transparent 70%); opacity: 0; transition: opacity 0.5s ease; }
        .program-card:hover { background: rgba(255, 255, 255, 0.1); transform: translateY(-15px) scale(1.02); box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3); }
        .program-card:hover::before { transform: scaleX(1); }
        .program-card:hover::after { opacity: 1; }
        .program-icon { width: 90px; height: 90px; margin: 0 auto 30px; display: flex; align-items: center; justify-content: center; background: var(--gradient-gold); border-radius: 50%; font-size: 2.2rem; color: var(--white); position: relative; z-index: 1; box-shadow: 0 15px 40px rgba(184, 134, 11, 0.4); transition: all 0.5s ease; }
        .program-card:hover .program-icon { transform: rotateY(360deg); }
        .program-card h3 { font-size: 1.5rem; margin-bottom: 15px; color: var(--white); font-weight: 700; position: relative; z-index: 1; }
        .program-card p { font-size: 0.95rem; color: rgba(255, 255, 255, 0.7); margin-bottom: 25px; line-height: 1.8; position: relative; z-index: 1; }
        .program-price { font-size: 1.3rem; font-weight: 700; background: var(--gradient-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; position: relative; z-index: 1; }

        /* Timeline Section */
        .timeline-section { background: var(--off-white); }
        .timeline { position: relative; max-width: 800px; margin: 0 auto; }
        .timeline::before { content: ''; position: absolute; left: 50%; transform: translateX(-50%); width: 4px; height: 100%; background: var(--gradient-gold); border-radius: 2px; }
        .timeline-item { display: flex; justify-content: flex-end; padding: 20px 0; width: 50%; position: relative; }
        .timeline-item:nth-child(even) { justify-content: flex-start; margin-left: 50%; }
        .timeline-content { background: var(--white); padding: 30px; border-radius: 20px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1); max-width: 350px; position: relative; transition: all 0.3s ease; }
        .timeline-content:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15); }
        .timeline-content::before { content: ''; position: absolute; top: 30px; width: 20px; height: 20px; background: var(--gradient-gold); border-radius: 50%; box-shadow: 0 5px 20px rgba(184, 134, 11, 0.4); }
        .timeline-item:nth-child(odd) .timeline-content::before { right: -40px; }
        .timeline-item:nth-child(even) .timeline-content::before { left: -40px; }
        .timeline-content h4 { font-size: 1.2rem; color: var(--black); margin-bottom: 10px; font-weight: 700; }
        .timeline-content p { font-size: 0.95rem; color: #666; margin-bottom: 10px; }
        .timeline-date { font-size: 0.85rem; color: var(--primary-gold); font-weight: 600; }

        /* FAQ Section */
        .faq-container { max-width: 800px; margin: 0 auto; }
        .faq-item { background: var(--white); border-radius: 20px; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); overflow: hidden; border: 1px solid rgba(0, 0, 0, 0.05); transition: all 0.3s ease; }
        .faq-item:hover { box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1); }
        .faq-question { padding: 25px 30px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600; font-size: 1.1rem; color: var(--black); transition: all 0.3s ease; }
        .faq-question:hover { color: var(--primary-gold); }
        .faq-question i { transition: transform 0.3s ease; color: var(--primary-gold); }
        .faq-item.active .faq-question i { transform: rotate(180deg); }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
        .faq-item.active .faq-answer { max-height: 300px; }
        .faq-answer p { padding: 0 30px 25px; color: #666; line-height: 1.8; }

        /* Location Section */
        .location-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .location-info { padding: 50px; background: var(--white); border-radius: 30px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1); }
        .location-info h3 { font-size: 2rem; color: var(--black); margin-bottom: 30px; font-weight: 700; }
        .contact-item { display: flex; align-items: flex-start; gap: 20px; margin-bottom: 25px; padding: 20px; background: var(--off-white); border-radius: 15px; transition: all 0.3s ease; }
        .contact-item:hover { transform: translateX(10px); }
        .contact-item i { width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; background: var(--gradient-gold); color: var(--white); border-radius: 15px; flex-shrink: 0; font-size: 1.3rem; }
        .contact-item div h4 { font-size: 1rem; color: var(--black); margin-bottom: 5px; font-weight: 600; }
        .contact-item div p { font-size: 0.95rem; color: #666; }
        .location-map { border-radius: 30px; overflow: hidden; height: 450px; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15); }
        .location-map iframe { width: 100%; height: 100%; border: none; }

        /* Footer */
        .footer { background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%); color: var(--white); padding: 80px 20px 30px; position: relative; }
        .footer::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--gradient-gold); }
        .footer-container { max-width: 1280px; margin: 0 auto; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 50px; margin-bottom: 50px; }
        .footer-brand h3 { font-size: 1.8rem; background: var(--gradient-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 15px; }
        .footer-brand p { color: rgba(255, 255, 255, 0.7); margin-top: 15px; font-size: 0.95rem; line-height: 1.8; }
        .footer-social { display: flex; gap: 12px; margin-top: 25px; }
        .footer-social a { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background: rgba(255, 255, 255, 0.1); border-radius: 50%; color: var(--white); transition: all 0.3s ease; }
        .footer-social a:hover { background: var(--gradient-gold); transform: translateY(-5px); }
        .footer-column h4 { font-size: 1.2rem; margin-bottom: 25px; color: var(--white); font-weight: 600; }
        .footer-column ul { list-style: none; }
        .footer-column ul li { margin-bottom: 12px; }
        .footer-column ul li a { color: rgba(255, 255, 255, 0.7); text-decoration: none; font-size: 0.95rem; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; }
        .footer-column ul li a:hover { color: var(--secondary-gold); transform: translateX(5px); }
        .footer-bottom { border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 30px; text-align: center; color: rgba(255, 255, 255, 0.5); font-size: 0.9rem; }

        /* Mobile Menu */
        .mobile-nav { display: none; position: fixed; top: 80px; left: 0; right: 0; background: var(--white); padding: 25px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); z-index: 999; }
        .mobile-nav.active { display: block; }
        .mobile-nav a { display: block; padding: 15px 0; color: var(--dark-gray); text-decoration: none; border-bottom: 1px solid #eee; font-weight: 500; }
        .mobile-nav-buttons { display: flex; gap: 15px; margin-top: 20px; }
        .mobile-nav-buttons .btn { flex: 1; text-align: center; justify-content: center; }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-title { font-size: 3rem; }
            .programs-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .navbar-menu, .navbar-buttons { display: none; }
            .mobile-menu-btn { display: block; }
            .hero-container, .about-grid, .location-grid { grid-template-columns: 1fr; text-align: center; }
            .hero-title { font-size: 2.5rem; }
            .hero-subtitle { margin: 0 auto 30px; }
            .hero-buttons { justify-content: center; }
            .hero-stats { justify-content: center; }
            .hero-visual { order: -1; }
            .floating-card { display: none; }
            .programs-grid { grid-template-columns: 1fr; }
            .about-features { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; text-align: center; }
            .footer-social { justify-content: center; }
            .timeline::before { left: 20px; }
            .timeline-item, .timeline-item:nth-child(even) { width: 100%; margin-left: 0; padding-left: 50px; justify-content: flex-start; }
            .timeline-item:nth-child(odd) .timeline-content::before,
            .timeline-item:nth-child(even) .timeline-content::before { left: -40px; right: auto; }
        }

        /* Alert */
        .alert { padding: 18px 25px; border-radius: 15px; margin: 20px; display: flex; align-items: center; gap: 12px; font-weight: 500; }
        .alert-success { background: linear-gradient(135deg, rgba(27, 94, 32, 0.1), rgba(76, 175, 80, 0.1)); color: var(--green-islamic); border: 1px solid rgba(27, 94, 32, 0.2); }
        .alert-error { background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.2); }
    </style>
</head>
<body>
    <div class="animated-bg"></div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                @if($settings->logo)
                    <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo">
                @else
                    <div style="width: 50px; height: 50px; background: var(--gradient-gold); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-mosque" style="color: white; font-size: 1.5rem;"></i>
                    </div>
                @endif
                <div class="navbar-brand-text">
                    <h1>Maskanul Huffadz</h1>
                    <span>TA {{ $settings->academic_year ?? '2025/2026' }}</span>
                </div>
            </a>
            <ul class="navbar-menu">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#programs">Program</a></li>
                <li><a href="#timeline">Alur</a></li>
                <li><a href="#faq">FAQ</a></li>
                <li><a href="#location">Lokasi</a></li>
            </ul>
            <div class="navbar-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                @if($settings->is_ppdb_open)
                    <a href="{{ route('register') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Daftar</a>
                @endif
            </div>
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <!-- Mobile Nav -->
    <div class="mobile-nav" id="mobileNav">
        <a href="#home" onclick="toggleMobileMenu()">Beranda</a>
        <a href="#about" onclick="toggleMobileMenu()">Tentang</a>
        <a href="#programs" onclick="toggleMobileMenu()">Program</a>
        <a href="#timeline" onclick="toggleMobileMenu()">Alur Pendaftaran</a>
        <a href="#faq" onclick="toggleMobileMenu()">FAQ</a>
        <a href="#location" onclick="toggleMobileMenu()">Lokasi</a>
        <div class="mobile-nav-buttons">
            <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
            @if($settings->is_ppdb_open)
                <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
            @endif
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success" style="position: fixed; top: 100px; left: 50%; transform: translateX(-50%); z-index: 1001; max-width: 500px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error" style="position: fixed; top: 100px; left: 50%; transform: translateX(-50%); z-index: 1001; max-width: 500px;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Hero -->
    <section class="hero" id="home">
        <div class="hero-pattern"></div>
        <div class="particles" id="particles"></div>
        <div class="hero-container">
            <div class="hero-content">
                @if($settings->is_ppdb_open)
                    <div class="hero-badge open"><i class="fas fa-door-open"></i> Pendaftaran Dibuka!</div>
                @else
                    <div class="hero-badge closed"><i class="fas fa-door-closed"></i> Pendaftaran Ditutup</div>
                @endif
                <h1 class="hero-title">PPDB <span>Maskanul Huffadz</span></h1>
                <p class="hero-subtitle">{{ $settings->description ?? 'Selamat datang di portal pendaftaran Maskanul Huffadz. Kami menyediakan program pendidikan Al-Quran berkualitas untuk putra-putri Anda.' }}</p>
                <div class="hero-buttons">
                    @if($settings->is_ppdb_open)
                        <a href="{{ route('register') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Daftar Sekarang</a>
                    @endif
                    <a href="#programs" class="btn btn-outline"><i class="fas fa-book-quran"></i> Lihat Program</a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-number" data-count="500">0</div>
                        <div class="stat-label">Santri Aktif</div>
                    </div>
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-number" data-count="15">0</div>
                        <div class="stat-label">Tahun Berdiri</div>
                    </div>
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="stat-number" data-count="200">0</div>
                        <div class="stat-label">Hafidz Lulus</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual" data-aos="fade-left" data-aos-duration="1000">
                <div class="hero-image-wrapper">
                    @if($settings->hero_image)
                        <img src="{{ asset('storage/' . $settings->hero_image) }}" alt="Masjid" class="hero-mosque">
                    @else
                        <img src="https://images.unsplash.com/photo-1585036156171-384164a8c675?w=600&h=450&fit=crop" alt="Masjid" class="hero-mosque">
                    @endif
                    <div class="floating-card glass-card card-1">
                        <i class="fas fa-book-quran"></i>
                        <h4>Tahfidz Quran</h4>
                        <p>Program Unggulan</p>
                    </div>
                    <div class="floating-card glass-card card-2">
                        <i class="fas fa-graduation-cap"></i>
                        <h4>Pendidikan Islami</h4>
                        <p>Berkualitas Tinggi</p>
                    </div>
                    <div class="floating-card glass-card card-3">
                        <i class="fas fa-star"></i>
                        <h4>Akreditasi A</h4>
                        <p>Terpercaya</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="section" id="about">
        <div class="section-container">
            <div class="about-grid">
                <div class="about-image" data-aos="fade-right">
                    @if($settings->about_image)
                        <img src="{{ asset('storage/' . $settings->about_image) }}" alt="Santri">
                    @else
                        <img src="https://images.unsplash.com/photo-1609599006353-e629aaabfeae?w=600&h=500&fit=crop" alt="Santri">
                    @endif
                </div>
                <div class="about-content" data-aos="fade-left">
                    <span class="section-badge">Tentang Kami</span>
                    <h3>{{ $settings->title ?? 'Maskanul Huffadz' }}</h3>
                    <p>{{ $settings->subtitle ?? 'Lembaga pendidikan Al-Quran yang berkomitmen mencetak generasi penghafal Al-Quran yang berakhlak mulia dan berwawasan luas.' }}</p>
                    <div class="about-features">
                        <div class="about-feature"><i class="fas fa-quran"></i><div><h4>Tahfidz Quran</h4><p>Program unggulan</p></div></div>
                        <div class="about-feature"><i class="fas fa-chalkboard-teacher"></i><div><h4>Ustad Berpengalaman</h4><p>Tenaga pengajar berkualitas</p></div></div>
                        <div class="about-feature"><i class="fas fa-home"></i><div><h4>Lingkungan Islami</h4><p>Suasana kondusif</p></div></div>
                        <div class="about-feature"><i class="fas fa-user-graduate"></i><div><h4>Alumni Sukses</h4><p>Output berkualitas</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs -->
    <section class="section programs-section" id="programs">
        <div class="section-container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-badge">Program Kami</span>
                <h2 class="section-title">Pilihan Program Pendidikan</h2>
                <p class="section-subtitle">Pilih program yang sesuai dengan kebutuhan dan usia putra-putri Anda</p>
            </div>
            <div class="programs-grid">
                @forelse($programs as $index => $program)
                    <div class="program-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="program-icon">
                            @if($program->slug == 'iddah-tahfidz')<i class="fas fa-book-quran"></i>
                            @elseif($program->slug == 'lil-athfal')<i class="fas fa-child"></i>
                            @else<i class="fas fa-baby"></i>@endif
                        </div>
                        <h3>{{ $program->name }}</h3>
                        <p>{{ $program->description ?? 'Program pendidikan berkualitas untuk generasi penghafal Al-Quran.' }}</p>
                        @if($program->price > 0)
                            <div class="program-price">Rp {{ number_format($program->price, 0, ',', '.') }}</div>
                        @else
                            <div class="program-price">Hubungi Kami</div>
                        @endif
                    </div>
                @empty
                    <div class="program-card"><div class="program-icon"><i class="fas fa-book-quran"></i></div><h3>I'dad Tahfidz</h3><p>Program menghafal Al-Quran intensif.</p><div class="program-price">Hubungi Kami</div></div>
                    <div class="program-card"><div class="program-icon"><i class="fas fa-child"></i></div><h3>Lil Athfal</h3><p>Program untuk anak-anak.</p><div class="program-price">Hubungi Kami</div></div>
                    <div class="program-card"><div class="program-icon"><i class="fas fa-baby"></i></div><h3>PaudQu</h3><p>PAUD berbasis Al-Quran.</p><div class="program-price">Hubungi Kami</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Timeline -->
    <section class="section timeline-section" id="timeline">
        <div class="section-container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-badge">Alur Pendaftaran</span>
                <h2 class="section-title">Tahapan PPDB</h2>
                <p class="section-subtitle">Ikuti langkah-langkah berikut untuk mendaftar</p>
            </div>
            <div class="timeline">
                <div class="timeline-item" data-aos="fade-right"><div class="timeline-content"><h4>1. Registrasi Akun</h4><p>Buat akun di portal PPDB</p><span class="timeline-date"><i class="fas fa-user-plus"></i> Langkah Awal</span></div></div>
                <div class="timeline-item" data-aos="fade-left"><div class="timeline-content"><h4>2. Isi Formulir</h4><p>Lengkapi data pendaftaran</p><span class="timeline-date"><i class="fas fa-edit"></i> Data Lengkap</span></div></div>
                <div class="timeline-item" data-aos="fade-right"><div class="timeline-content"><h4>3. Pembayaran</h4><p>Bayar biaya pendaftaran</p><span class="timeline-date"><i class="fas fa-credit-card"></i> Konfirmasi</span></div></div>
                <div class="timeline-item" data-aos="fade-left"><div class="timeline-content"><h4>4. Wawancara</h4><p>Ikuti sesi wawancara</p><span class="timeline-date"><i class="fas fa-comments"></i> Seleksi</span></div></div>
                <div class="timeline-item" data-aos="fade-right"><div class="timeline-content"><h4>5. Pengumuman</h4><p>Cek hasil kelulusan</p><span class="timeline-date"><i class="fas fa-bullhorn"></i> Hasil</span></div></div>
                <div class="timeline-item" data-aos="fade-left"><div class="timeline-content"><h4>6. Daftar Ulang</h4><p>Lengkapi berkas & pembayaran</p><span class="timeline-date"><i class="fas fa-check-circle"></i> Selesai</span></div></div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section" id="faq">
        <div class="section-container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-badge">FAQ</span>
                <h2 class="section-title">Pertanyaan Umum</h2>
                <p class="section-subtitle">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
            </div>
            <div class="faq-container">
                <div class="faq-item" data-aos="fade-up"><div class="faq-question" onclick="toggleFaq(this)">Kapan pendaftaran PPDB dibuka?<i class="fas fa-chevron-down"></i></div><div class="faq-answer"><p>Pendaftaran PPDB dibuka sesuai jadwal yang tertera di website. Pantau terus halaman ini untuk informasi terbaru.</p></div></div>
                <div class="faq-item" data-aos="fade-up"><div class="faq-question" onclick="toggleFaq(this)">Apa saja persyaratan pendaftaran?<i class="fas fa-chevron-down"></i></div><div class="faq-answer"><p>Persyaratan meliputi: fotokopi KK, akta kelahiran, pas foto, dan mengisi formulir pendaftaran online.</p></div></div>
                <div class="faq-item" data-aos="fade-up"><div class="faq-question" onclick="toggleFaq(this)">Berapa biaya pendaftaran?<i class="fas fa-chevron-down"></i></div><div class="faq-answer"><p>Biaya pendaftaran berbeda untuk setiap program. Silakan lihat detail di halaman program masing-masing.</p></div></div>
                <div class="faq-item" data-aos="fade-up"><div class="faq-question" onclick="toggleFaq(this)">Bagaimana proses seleksi?<i class="fas fa-chevron-down"></i></div><div class="faq-answer"><p>Proses seleksi meliputi verifikasi berkas, wawancara dengan orang tua dan calon santri, serta tes kemampuan dasar.</p></div></div>
                <div class="faq-item" data-aos="fade-up"><div class="faq-question" onclick="toggleFaq(this)">Apakah ada program beasiswa?<i class="fas fa-chevron-down"></i></div><div class="faq-answer"><p>Ya, tersedia program beasiswa untuk santri berprestasi dan dari keluarga kurang mampu. Informasi lebih lanjut hubungi panitia.</p></div></div>
            </div>
        </div>
    </section>

    <!-- Location -->
    <section class="section" id="location" style="background: var(--off-white);">
        <div class="section-container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-badge">Lokasi Kami</span>
                <h2 class="section-title">Temukan Kami</h2>
                <p class="section-subtitle">Kunjungi untuk informasi lebih lanjut</p>
            </div>
            <div class="location-grid">
                <div class="location-info" data-aos="fade-right">
                    <h3>Kontak & Alamat</h3>
                    <div class="contact-item"><i class="fas fa-map-marker-alt"></i><div><h4>Alamat</h4><p>{{ $settings->address ?? 'Jl. Pesantren No. 1' }}</p></div></div>
                    <div class="contact-item"><i class="fas fa-phone"></i><div><h4>Telepon</h4><p>{{ $settings->phone ?? '08xxxxxxxxxx' }}</p></div></div>
                    <div class="contact-item"><i class="fas fa-envelope"></i><div><h4>Email</h4><p>{{ $settings->email ?? 'info@maskanulhuffadz.ac.id' }}</p></div></div>
                    @if($settings->registration_start && $settings->registration_end)
                    <div class="contact-item"><i class="fas fa-calendar-alt"></i><div><h4>Periode Pendaftaran</h4><p>{{ \Carbon\Carbon::parse($settings->registration_start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($settings->registration_end)->format('d M Y') }}</p></div></div>
                    @endif
                </div>
                <div class="location-map" data-aos="fade-left">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613!3d-6.194741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTEnNDEuMSJTIDEwNsKwNDknMTAuNCJF!5e0!3m2!1sen!2sid!4v1234567890" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3>Maskanul Huffadz</h3>
                    <p>Mencetak generasi penghafal Al-Quran yang berakhlak mulia, berwawasan luas, dan siap menjadi pemimpin umat.</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="footer-column"><h4>Menu</h4><ul><li><a href="#home"><i class="fas fa-chevron-right"></i> Beranda</a></li><li><a href="#about"><i class="fas fa-chevron-right"></i> Tentang</a></li><li><a href="#programs"><i class="fas fa-chevron-right"></i> Program</a></li><li><a href="#location"><i class="fas fa-chevron-right"></i> Lokasi</a></li></ul></div>
                <div class="footer-column"><h4>Program</h4><ul><li><a href="#"><i class="fas fa-chevron-right"></i> I'dad Tahfidz</a></li><li><a href="#"><i class="fas fa-chevron-right"></i> Lil Athfal</a></li><li><a href="#"><i class="fas fa-chevron-right"></i> PaudQu</a></li></ul></div>
                <div class="footer-column"><h4>Bantuan</h4><ul><li><a href="#faq"><i class="fas fa-chevron-right"></i> FAQ</a></li><li><a href="#timeline"><i class="fas fa-chevron-right"></i> Alur Pendaftaran</a></li><li><a href="#location"><i class="fas fa-chevron-right"></i> Hubungi Kami</a></li></ul></div>
            </div>
            <div class="footer-bottom"><p>&copy; {{ date('Y') }} Maskanul Huffadz. All rights reserved.</p></div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 100 });

        function toggleMobileMenu() { document.getElementById('mobileNav').classList.toggle('active'); }
        function toggleFaq(el) { el.parentElement.classList.toggle('active'); }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const t = document.querySelector(this.getAttribute('href'));
                if(t) t.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        // Navbar scroll
        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
        });

        // Counter animation
        const counters = document.querySelectorAll('.stat-number');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    const el = entry.target;
                    const target = +el.getAttribute('data-count');
                    let count = 0;
                    const increment = target / 50;
                    const timer = setInterval(() => {
                        count += increment;
                        if(count >= target) { el.textContent = target + '+'; clearInterval(timer); }
                        else { el.textContent = Math.floor(count) + '+'; }
                    }, 30);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(c => observer.observe(c));

        // Particles
        const particles = document.getElementById('particles');
        for(let i = 0; i < 20; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.left = Math.random() * 100 + '%';
            p.style.animationDelay = Math.random() * 20 + 's';
            p.style.animationDuration = (15 + Math.random() * 10) + 's';
            particles.appendChild(p);
        }

        // Auto-hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(a => {
                a.style.opacity = '0';
                a.style.transition = 'opacity 0.5s';
                setTimeout(() => a.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
