<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Fikih Harta Anak Yatim – Ebook Gratis | Kowpi.id</title>
    <meta name="description" content="Dapatkan ebook gratis panduan fikih harta anak yatim yang praktis dan sesuai syariat. Lindungi diri Anda dari ancaman memakan harta mereka secara zalim.">
    <meta name="keywords" content="ebook fikih anak yatim, harta anak yatim, panduan wali yatim, fikih muamalah, ebook gratis islami">
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-kowpi.png') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --brand-50: #fdf8f6;
            --brand-100: #f7ede8;
            --brand-200: #efd6cc;
            --brand-300: #e0b49e;
            --brand-400: #cc8a6a;
            --brand-500: #b86a4a;
            --brand-600: #8c4835;
            --brand-700: #6e3428;
            --brand-800: #4f261e;
            --brand-900: #341916;
            --brand-950: #1e0e0c;
            --gold: #d4a847;
            --gold-light: #f0c96b;
            --dark-bg: #0d0a09;
            --dark-card: #1a1210;
            --dark-border: #2d1f1a;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
            max-width: 100%;
            width: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--dark-bg);
            color: #e8ddd9;
            overflow-x: hidden;
            max-width: 100%;
            width: 100%;
            position: relative;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── HIDDEN UTILITY ─── */
        .hidden { display: none !important; }

        /* ─── SCROLLBAR ─── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--dark-bg); }
        ::-webkit-scrollbar-thumb { background: var(--brand-700); border-radius: 3px; }

        /* ─── SELECTION ─── */
        ::selection { background: var(--brand-600); color: #fff; }

        /* ─── NAVBAR ─── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            width: 100%;
            max-width: 100vw;
            box-sizing: border-box;
            z-index: 1000;
            padding: 16px 0;
            transition: all 0.4s ease;
        }
        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-sizing: border-box;
            width: 100%;
        }
        .navbar.scrolled {
            background: rgba(13, 10, 9, 0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--dark-border);
            padding: 12px 0;
        }
        .navbar-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            flex-shrink: 0;
        }
        .navbar-logo img {
            height: 36px;
            width: auto;
            transition: all 0.3s;
            display: block;
        }
        .navbar.scrolled .navbar-logo img {
            height: 30px;
        }
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .nav-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 15px;
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #9e8a82;
            text-decoration: none;
            border: 1px solid rgba(158, 138, 130, 0.25);
            background: rgba(45, 31, 26, 0.3);
            transition: all 0.3s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .nav-back:hover {
            color: #fff;
            border-color: rgba(212, 168, 71, 0.4);
            background: rgba(212, 168, 71, 0.08);
        }
        .nav-badge {
            background: linear-gradient(135deg, var(--brand-600), var(--brand-800));
            color: #fff;
            padding: 7px 18px;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 700;
            border: 1px solid var(--brand-500);
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(140, 72, 53, 0.25);
            line-height: 1.2;
        }
        .nav-badge:hover {
            background: linear-gradient(135deg, var(--brand-500), var(--brand-700));
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(140, 72, 53, 0.4);
            color: #fff;
        }
        .nav-badge-short {
            display: none;
        }

        /* ─── HERO ─── */
        .hero {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
            overflow-x: clip;
            padding: 120px 0 80px;
        }
        .hero-bg {
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(ellipse 80% 60% at 70% 30%, rgba(140, 72, 53, 0.18) 0%, transparent 70%),
                radial-gradient(ellipse 50% 50% at 20% 80%, rgba(212, 168, 71, 0.08) 0%, transparent 60%),
                linear-gradient(180deg, #0d0a09 0%, #1a1210 50%, #0d0a09 100%);
        }
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(140, 72, 53, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(140, 72, 53, 0.06) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 40%, transparent 80%);
        }
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: float 8s ease-in-out infinite;
        }
        .orb-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(140, 72, 53, 0.25) 0%, transparent 70%);
            top: -100px; right: -100px;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(212, 168, 71, 0.12) 0%, transparent 70%);
            bottom: 0; left: -50px;
            animation-delay: 3s;
        }
        .orb-3 {
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(140, 72, 53, 0.15) 0%, transparent 70%);
            top: 40%; left: 30%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        @media (max-width: 900px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 48px;
                text-align: center;
            }
            .hero-trust-strip { justify-content: center; }
            .float-badge-1 { left: 0; font-size: 0.75rem; padding: 8px 12px; }
            .float-badge-2 { right: 0; font-size: 0.75rem; padding: 8px 12px; }
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, rgba(212, 168, 71, 0.15), rgba(212, 168, 71, 0.05));
            border: 1px solid rgba(212, 168, 71, 0.3);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 24px;
        }
        .hero-eyebrow .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--gold);
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 5vw, 3.6rem);
            font-weight: 800;
            line-height: 1.15;
            color: #fff;
            margin-bottom: 24px;
        }
        .hero-title .highlight {
            background: linear-gradient(135deg, var(--gold-light), var(--gold), var(--brand-400));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-subtitle {
            font-size: 1.1rem;
            line-height: 1.75;
            color: #9e8a82;
            margin-bottom: 40px;
            max-width: 480px;
        }
        .hero-cta {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        @media (max-width: 900px) {
            .hero-cta { justify-content: center; }
            .hero-subtitle { margin-left: auto; margin-right: auto; }
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 32px;
            background: linear-gradient(135deg, var(--brand-500), var(--brand-700));
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 8px 32px rgba(140, 72, 53, 0.35);
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(140, 72, 53, 0.5); }
        .btn-primary:hover::before { opacity: 1; }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 32px;
            background: transparent;
            color: #c9b8b0;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 14px;
            border: 1px solid rgba(200, 180, 170, 0.2);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-ghost:hover {
            background: rgba(200, 180, 170, 0.05);
            border-color: rgba(200, 180, 170, 0.4);
            color: #fff;
            transform: translateY(-2px);
        }

        /* ─── BOOK MOCKUP ─── */
        .book-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .book-glow {
            position: absolute;
            width: 320px; height: 420px;
            background: radial-gradient(ellipse, rgba(140, 72, 53, 0.3) 0%, transparent 70%);
            border-radius: 20px;
            filter: blur(40px);
        }
        .book-card {
            position: relative;
            width: 280px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 
                0 40px 80px rgba(0,0,0,0.6),
                0 0 0 1px rgba(212, 168, 71, 0.15),
                inset 0 1px 0 rgba(255,255,255,0.1);
            transform: perspective(1000px) rotateY(-5deg);
            transition: transform 0.5s ease;
            animation: book-float 6s ease-in-out infinite;
        }
        .book-card:hover { transform: perspective(1000px) rotateY(0deg) scale(1.02); }
        @keyframes book-float {
            0%, 100% { transform: perspective(1000px) rotateY(-5deg) translateY(0); }
            50% { transform: perspective(1000px) rotateY(-5deg) translateY(-12px); }
        }
        .book-card img {
            width: 100%;
            display: block;
        }
        .book-badge {
            position: absolute;
            top: 16px; right: 16px;
            background: linear-gradient(135deg, var(--gold), #b8860b);
            color: var(--dark-bg);
            font-size: 0.7rem;
            font-weight: 800;
            padding: 6px 12px;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Floating badges around book */
        .float-badge {
            position: absolute;
            background: rgba(26, 18, 16, 0.9);
            border: 1px solid rgba(212, 168, 71, 0.25);
            backdrop-filter: blur(12px);
            border-radius: 12px;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #e8ddd9;
            white-space: nowrap;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        }
        .float-badge-1 {
            top: 10%;
            left: -60px;
            animation: badge-float1 4s ease-in-out infinite;
        }
        .float-badge-2 {
            bottom: 20%;
            right: -60px;
            animation: badge-float2 5s ease-in-out infinite;
        }
        @keyframes badge-float1 {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        @keyframes badge-float2 {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(8px); }
        }

        /* ─── TRUST STRIP ─── */
        .trust-strip {
            padding: 24px 0;
            border-top: 1px solid rgba(255,255,255,0.04);
            border-bottom: 1px solid rgba(255,255,255,0.04);
            background: rgba(26, 18, 16, 0.6);
        }
        .trust-grid {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 40px;
        }
        .trust-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #c9b8b0;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .trust-item i { color: var(--gold); }

        /* ─── SECTION BASE ─── */
        .section { padding: 96px 0; }
        .section-light {
            background: linear-gradient(180deg, #faf8f6 0%, #fff 50%, #faf8f6 100%);
            color: #1a1210;
        }
        .section-dark {
            background: linear-gradient(180deg, var(--dark-bg) 0%, var(--dark-card) 50%, var(--dark-bg) 100%);
        }
        .section-deep {
            background: linear-gradient(180deg, var(--brand-950) 0%, var(--dark-card) 100%);
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 16px;
        }
        .label-gold { color: var(--gold); }
        .label-brand { color: var(--brand-400); }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
        }
        .section-title-dark { color: #fff; }
        .section-title-light { color: #1a0f0c; }

        .section-desc {
            font-size: 1.05rem;
            line-height: 1.8;
            max-width: 600px;
        }
        .desc-dark { color: #9e8a82; }
        .desc-light { color: #5a4a44; }

        /* ─── PAIN POINTS ─── */
        .pain-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 56px;
        }
        .pain-card {
            background: #fff;
            border: 1px solid #ede5e0;
            border-radius: 20px;
            padding: 28px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .pain-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 4px; height: 100%;
            background: linear-gradient(180deg, var(--brand-400), var(--brand-600));
            opacity: 0;
            transition: opacity 0.3s;
        }
        .pain-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(140, 72, 53, 0.12);
            border-color: var(--brand-200);
        }
        .pain-card:hover::before { opacity: 1; }
        .pain-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #fdf2f0, #fbe4df);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--brand-500);
        }
        .pain-text {
            font-size: 0.95rem;
            font-weight: 500;
            color: #3a2822;
            line-height: 1.6;
        }
        .pain-cta-box {
            margin-top: 48px;
            background: linear-gradient(135deg, #fdf6f4, #fff);
            border: 1px solid var(--brand-200);
            border-radius: 20px;
            padding: 32px;
            text-align: center;
        }
        .pain-cta-box p {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--brand-700);
            line-height: 1.6;
        }

        /* ─── CHAPTERS DARK ─── */
        .chapters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 56px;
        }
        .chapter-card {
            background: linear-gradient(135deg, rgba(45, 31, 26, 0.8), rgba(30, 20, 16, 0.9));
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            padding: 32px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            cursor: default;
        }
        .chapter-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            background: radial-gradient(circle, rgba(212, 168, 71, 0.12) 0%, transparent 70%);
            border-radius: 50%;
        }
        .chapter-card:hover {
            transform: translateY(-6px);
            border-color: rgba(212, 168, 71, 0.3);
            box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(212, 168, 71, 0.15);
        }
        .chapter-num {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, rgba(212, 168, 71, 0.4), rgba(212, 168, 71, 0.1));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 16px;
        }
        .chapter-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #e8ddd9;
            margin-bottom: 8px;
        }
        .chapter-desc {
            font-size: 0.875rem;
            color: #6b5a54;
            line-height: 1.6;
        }

        /* Chapter titles mapping */
        .chapter-titles { display: none; }

        /* ─── AUTHOR + FEATURES (LIGHT) ─── */
        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }
        @media (max-width: 900px) {
            .features-grid { grid-template-columns: 1fr; gap: 40px; }
        }

        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 32px;
        }
        .feature-item {
            background: #fff;
            border: 1px solid #ede5e0;
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.3s;
        }
        .feature-item:hover {
            border-color: var(--brand-300);
            box-shadow: 0 8px 24px rgba(140, 72, 53, 0.1);
            transform: translateX(4px);
        }
        .feature-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--brand-500), var(--brand-700));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #fff;
            box-shadow: 0 4px 12px rgba(140, 72, 53, 0.3);
        }
        .feature-name {
            font-size: 1rem;
            font-weight: 700;
            color: #1a0f0c;
        }
        .feature-sub {
            font-size: 0.82rem;
            color: #7a6560;
            margin-top: 2px;
        }

        /* Stats row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 40px;
        }
        @media (max-width: 600px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
        }
        .stat-box {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #fdf6f4, #fff);
            border: 1px solid var(--brand-200);
            border-radius: 16px;
        }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--brand-600), var(--brand-400));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #9e8a82;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        /* Author card */
        .author-card {
            background: linear-gradient(135deg, #fff, #fdf6f4);
            border: 1px solid var(--brand-200);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 16px 48px rgba(140, 72, 53, 0.1);
            position: relative;
            overflow: hidden;
        }
        .author-card::before {
            content: '"';
            position: absolute;
            top: 20px; right: 24px;
            font-family: 'Playfair Display', serif;
            font-size: 8rem;
            color: var(--brand-100);
            line-height: 1;
        }
        .author-avatar {
            width: 100px; height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 8px 24px rgba(140, 72, 53, 0.2);
            margin-bottom: 20px;
        }
        .author-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: #1a0f0c;
            margin-bottom: 4px;
        }
        .author-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--brand-500);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .author-bio {
            font-size: 0.95rem;
            color: #5a4a44;
            line-height: 1.75;
        }
        .credential-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 20px;
        }
        .chip {
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--brand-100);
            color: var(--brand-700);
            border: 1px solid var(--brand-200);
        }

        /* ─── TARGET AUDIENCE ─── */
        .audience-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-top: 56px;
        }
        @media (max-width: 700px) {
            .audience-grid { grid-template-columns: 1fr; }
        }
        .audience-card {
            border-radius: 24px;
            padding: 36px;
            position: relative;
            overflow: hidden;
        }
        .audience-yes {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #86efac;
        }
        .audience-no {
            background: linear-gradient(135deg, #fff1f2, #ffe4e6);
            border: 1px solid #fca5a5;
        }
        .audience-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .audience-yes .audience-title { color: #14532d; }
        .audience-no .audience-title { color: #7f1d1d; }
        .audience-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .audience-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .audience-yes .audience-list li { color: #166534; }
        .audience-no .audience-list li { color: #991b1b; }
        .list-icon-yes { color: #16a34a; flex-shrink: 0; margin-top: 2px; }
        .list-icon-no { color: #dc2626; flex-shrink: 0; margin-top: 2px; }

        /* ─── FORM SECTION ─── */
        .form-section {
            padding: 96px 0;
            background: linear-gradient(180deg, var(--brand-950) 0%, #0d0a09 100%);
            position: relative;
            overflow: hidden;
        }
        .form-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(ellipse 60% 50% at 50% 50%, rgba(140, 72, 53, 0.2) 0%, transparent 70%);
        }
        .form-section-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        @media (max-width: 900px) {
            .form-section-grid { grid-template-columns: 1fr; gap: 48px; }
        }
        .form-promo h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            color: #fff;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 24px;
        }
        .form-promo p {
            color: #9e8a82;
            font-size: 1.05rem;
            line-height: 1.8;
            margin-bottom: 32px;
        }
        .value-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .value-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #c9b8b0;
            font-size: 0.95rem;
            font-weight: 500;
        }
        .value-list li i { color: var(--gold); flex-shrink: 0; }

        /* Form Card */
        .form-card {
            background: rgba(26, 18, 16, 0.8);
            border: 1px solid rgba(212, 168, 71, 0.15);
            border-radius: 28px;
            padding: 48px;
            backdrop-filter: blur(20px);
            box-shadow: 0 40px 80px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.05);
        }
        .form-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
        }
        .form-card-sub {
            color: #6b5a54;
            font-size: 0.9rem;
            margin-bottom: 32px;
        }

        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #9e8a82;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }
        .form-input {
            width: 100%;
            padding: 14px 18px;
            background: rgba(45, 31, 26, 0.5);
            border: 1px solid rgba(212, 168, 71, 0.12);
            border-radius: 12px;
            color: #e8ddd9;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.3s;
            outline: none;
        }
        .form-input::placeholder { color: #4a3530; }
        .form-input:focus {
            border-color: rgba(212, 168, 71, 0.4);
            background: rgba(45, 31, 26, 0.8);
            box-shadow: 0 0 0 3px rgba(212, 168, 71, 0.08);
        }

        .form-checkbox-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-top: 4px;
        }
        .form-checkbox-row input[type="checkbox"] {
            width: 18px; height: 18px;
            margin-top: 2px;
            accent-color: var(--brand-500);
            flex-shrink: 0;
        }
        .form-checkbox-row label {
            font-size: 0.875rem;
            color: #6b5a54;
            line-height: 1.5;
        }

        /* Date picker row */
        .date-picker-row {
            display: grid;
            grid-template-columns: 1fr 1.4fr 1fr;
            gap: 10px;
        }
        .date-select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239e8a82' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 32px;
            cursor: pointer;
        }
        .form-input select, select.form-input {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239e8a82' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--brand-500), var(--brand-700));
            color: #fff;
            font-family: inherit;
            font-size: 1.05rem;
            font-weight: 700;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 8px 32px rgba(140, 72, 53, 0.4);
            margin-top: 28px;
            position: relative;
            overflow: hidden;
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%);
            transform: rotate(45deg);
            transition: all 0.5s;
            opacity: 0;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 16px 48px rgba(140, 72, 53, 0.5); }
        .btn-submit:hover::before { opacity: 1; }

        /* Instant Ebook Download Button */
        .btn-instant-download {
            display: flex;
            width: 100%;
            box-sizing: border-box;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 22px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #ffffff !important;
            text-decoration: none;
            font-family: inherit;
            font-weight: 700;
            font-size: 0.96rem;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
            transition: all 0.25s ease;
            border: 1px solid rgba(255, 255, 255, 0.25);
            cursor: pointer;
            text-align: center;
        }
        .btn-instant-download:hover {
            background: linear-gradient(135deg, #047857, #059669);
            box-shadow: 0 8px 28px rgba(16, 185, 129, 0.5);
            transform: translateY(-2px);
            color: #ffffff !important;
        }
        .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

        /* Security note */
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 0.78rem;
            color: #4a3530;
            margin-top: 16px;
        }

        /* ─── FAQ DARK ─── */
        .faq-list {
            margin-top: 56px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .faq-item {
            background: rgba(26, 18, 16, 0.8);
            border: 1px solid var(--dark-border);
            border-radius: 16px;
            overflow: hidden;
            transition: border-color 0.3s;
        }
        .faq-item.active {
            border-color: rgba(212, 168, 71, 0.25);
        }
        .faq-btn {
            width: 100%;
            padding: 22px 28px;
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            text-align: left;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 600;
            color: #c9b8b0;
            transition: color 0.3s;
        }
        .faq-item.active .faq-btn { color: var(--gold); }
        .faq-icon-wrap {
            width: 32px; height: 32px;
            border-radius: 50%;
            border: 1px solid var(--dark-border);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s;
            color: #6b5a54;
        }
        .faq-item.active .faq-icon-wrap {
            background: rgba(212, 168, 71, 0.1);
            border-color: rgba(212, 168, 71, 0.3);
            color: var(--gold);
        }
        .faq-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }
        .faq-content p {
            padding: 0 28px 22px;
            color: #6b5a54;
            font-size: 0.95rem;
            line-height: 1.75;
        }

        /* ─── UPSELL SECTION ─── */
        .upsell-section {
            padding: 96px 0;
            background: linear-gradient(135deg, var(--dark-card), var(--dark-bg));
            position: relative;
            overflow: hidden;
        }
        .upsell-inner {
            background: linear-gradient(135deg, rgba(45, 31, 26, 0.6), rgba(26, 18, 16, 0.9));
            border: 1px solid rgba(212, 168, 71, 0.2);
            border-radius: 32px;
            padding: 64px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0,0,0,0.4);
        }
        .upsell-inner::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(ellipse at center, rgba(212, 168, 71, 0.05) 0%, transparent 60%);
        }
        .upsell-inner h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 800;
            color: #fff;
            margin-bottom: 20px;
            position: relative;
        }
        .upsell-inner p {
            color: #9e8a82;
            font-size: 1.05rem;
            line-height: 1.8;
            max-width: 600px;
            margin: 0 auto 40px;
            position: relative;
        }
        .btn-wa {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 18px 40px;
            background: linear-gradient(135deg, #25d366, #128c7e);
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            border-radius: 16px;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 8px 32px rgba(37, 211, 102, 0.3);
            position: relative;
        }
        .btn-wa:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(37, 211, 102, 0.4); }

        /* ─── MODAL ─── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 1050;
            background: rgba(0,0,0,0.75);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        .modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }
        .modal-box {
            background: linear-gradient(145deg, #1d1311, #241714);
            border: 1px solid rgba(212, 168, 71, 0.25);
            border-radius: 24px;
            width: 100%;
            max-width: 480px;
            overflow: hidden;
            box-shadow: 0 35px 80px rgba(0, 0, 0, 0.7), 0 0 35px rgba(212, 168, 71, 0.05);
            transform: scale(0.92) translateY(20px);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-overlay.open .modal-box {
            transform: scale(1) translateY(0);
        }
        .modal-step {
            padding: 38px 36px 36px;
            box-sizing: border-box;
            width: 100%;
        }
        .modal-step-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .modal-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.18) 0%, rgba(16, 185, 129, 0.04) 70%);
            border: 1.5px solid rgba(16, 185, 129, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #10b981;
            box-shadow: 0 0 24px rgba(16, 185, 129, 0.22);
            flex-shrink: 0;
        }
        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.65rem;
            font-weight: 800;
            color: #ffffff;
            text-align: center;
            margin-bottom: 12px;
            letter-spacing: -0.01em;
            line-height: 1.25;
            width: 100%;
        }
        .modal-notice-text {
            color: #c4b5b0;
            font-size: 0.93rem;
            text-align: center;
            margin: 0 0 8px;
            line-height: 1.5;
            width: 100%;
        }
        .modal-email-pill-wrap {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 8px;
        }
        .modal-email-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: rgba(212, 168, 71, 0.12);
            border: 1px solid rgba(212, 168, 71, 0.32);
            color: var(--gold-light);
            font-weight: 700;
            font-size: 0.92rem;
            padding: 5px 16px;
            border-radius: 9999px;
            word-break: break-all;
            max-width: 100%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        .modal-instruction-text {
            color: #8c7a74;
            font-size: 0.85rem;
            text-align: center;
            margin: 0 0 22px;
            line-height: 1.5;
            width: 100%;
        }
        .modal-download-box {
            width: 100%;
            margin-bottom: 22px;
        }
        .modal-separator {
            height: 1px;
            width: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 168, 71, 0.25), transparent);
            margin: 0 0 18px;
        }
        .modal-support-text {
            color: #a89994;
            text-align: center;
            font-size: 0.88rem;
            line-height: 1.6;
            margin: 0 0 20px;
            width: 100%;
        }
        .modal-desc {
            color: #8c7a74;
            text-align: center;
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 24px;
        }
        .modal-btn-group {
            display: flex;
            flex-direction: column;
            gap: 11px;
            width: 100%;
        }
        .btn-modal-yes {
            width: 100%;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 15px 20px;
            background: linear-gradient(135deg, var(--brand-500), var(--brand-700));
            color: #ffffff;
            font-family: inherit;
            font-size: 0.96rem;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 16px rgba(140, 72, 53, 0.35);
            text-align: center;
        }
        .btn-modal-yes:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(140, 72, 53, 0.5);
        }
        .btn-modal-no {
            width: 100%;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 13px 20px;
            background: rgba(45, 31, 26, 0.5);
            color: #8c7b75;
            font-family: inherit;
            font-size: 0.92rem;
            font-weight: 600;
            border: 1px solid rgba(212, 168, 71, 0.12);
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            text-align: center;
        }
        .btn-modal-no:hover {
            color: #dfd7d3;
            background: rgba(55, 38, 32, 0.7);
            border-color: rgba(212, 168, 71, 0.25);
        }

        .modal-form .form-label { color: #6b5a54; }
        .back-btn {
            background: none;
            border: none;
            color: #4a3530;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.875rem;
            font-family: inherit;
            margin-bottom: 20px;
            transition: color 0.3s;
        }
        .back-btn:hover { color: #9e8a82; }

        /* ─── FOOTER ─── */
        .footer {
            background: var(--brand-950);
            border-top: 1px solid var(--dark-border);
            padding: 48px 0 32px;
        }
        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--gold);
        }
        .footer-logo span { color: #4a3530; }
        .footer-copy {
            font-size: 0.85rem;
            color: #9e8a82;
        }
        .footer-disclaimer {
            width: 100%;
            text-align: center;
            font-size: 0.78rem;
            color: #7a6560;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
            line-height: 1.7;
        }

        /* ─── SUCCESS MESSAGE ─── */
        #successMessage {
            background: linear-gradient(135deg, rgba(20, 83, 45, 0.3), rgba(22, 101, 52, 0.2));
            border: 1px solid rgba(134, 239, 172, 0.3);
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            margin-top: 24px;
        }
        #successMessage h3 { color: #86efac; font-size: 1.3rem; font-weight: 700; margin-bottom: 8px; }
        #successMessage p { color: #4ade80; font-size: 0.9rem; }
        #successMessage a { color: var(--gold); }

        /* ─── IMAGE MODAL ─── */
        .img-modal {
            position: fixed;
            inset: 0;
            z-index: 1100;
            background: rgba(0,0,0,0.92);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .img-modal.hidden { display: none !important; }
        .img-modal-inner img {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 16px;
            border: 1px solid var(--dark-border);
        }
        .img-modal-close {
            position: absolute;
            top: 20px; right: 20px;
            background: rgba(45,31,26,0.8);
            border: 1px solid var(--dark-border);
            border-radius: 50%;
            width: 40px; height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9e8a82;
            cursor: pointer;
            transition: all 0.3s;
        }
        .img-modal-close:hover { color: #fff; }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .navbar { padding: 12px 0; }
            .navbar-inner { padding: 0 16px; }
            .navbar-actions { gap: 8px; }
            .navbar-logo img { height: 30px; }
            .nav-badge { padding: 6px 14px; font-size: 0.76rem; }
            .nav-back { padding: 6px 12px; font-size: 0.74rem; }
            .hero { padding: 100px 0 60px; min-height: auto; }
            .hero-content { gap: 40px; }
            .hero-subtitle { font-size: 1rem; }
            .hero-cta { flex-direction: column; align-items: center; }
            .btn-primary, .btn-ghost { width: 100%; justify-content: center; padding: 14px 24px; }
            .book-card { width: 220px; }
            .book-glow { width: 250px; height: 320px; }
            .trust-grid { gap: 16px 24px; }
            .trust-item { font-size: 0.82rem; }
            .section { padding: 64px 0; }
            .pain-grid { grid-template-columns: 1fr; }
            .pain-card { padding: 20px; }
            .chapters-grid { grid-template-columns: 1fr; }
            .features-grid { gap: 32px; }
            .audience-grid { gap: 20px; }
            .audience-card { padding: 24px; }
            .form-section { padding: 64px 0; }
            .form-section-grid { gap: 40px; }
            .form-card { padding: 28px; }
            .upsell-inner { padding: 40px 24px; }
            .footer-inner { flex-direction: column; text-align: center; gap: 12px; }
            .float-badge-1 { left: 10px; top: 5%; }
            .float-badge-2 { right: 10px; bottom: 15%; }
        }
        @media (max-width: 540px) {
            .navbar { padding: 10px 0; }
            .navbar-inner { padding: 0 12px; }
            .navbar-actions { gap: 6px; }
            .navbar-logo img { height: 26px; }
            .nav-back { padding: 5px 10px; font-size: 0.72rem; gap: 4px; }
            .nav-badge { padding: 6px 12px; font-size: 0.72rem; letter-spacing: 0.2px; }
            .nav-badge-full { display: none; }
            .nav-badge-short { display: inline; }
        }
        @media (max-width: 480px) {
            .container { padding: 0 16px; }
            .hero { padding: 90px 0 48px; }
            .hero-title { font-size: 1.8rem; }
            .section-title { font-size: 1.5rem; }
            .book-card { width: 200px; }
            .form-card { padding: 24px 20px; }
            .form-card-title { font-size: 1.4rem; }
            .upsell-inner { padding: 32px 20px; border-radius: 24px; }
            .faq-btn { padding: 18px 20px; font-size: 0.9rem; }
            .btn-wa { padding: 16px 28px; font-size: 0.95rem; }
            .author-card { padding: 28px; }
            .stat-num { font-size: 1.5rem; }
            .modal-box { border-radius: 20px; }
            .modal-step { padding: 26px 18px; }
            .modal-title { font-size: 1.45rem; }
            .float-badge-1 { left: 5px; top: 0; }
            .float-badge-2 { right: 5px; bottom: 10%; }
        }
        @media (max-width: 400px) {
            .navbar-inner { padding: 0 8px; gap: 6px; }
            .navbar-logo img { height: 23px; }
            .nav-back-text { display: none; }
            .nav-back { padding: 5px 7px; border-radius: 50%; width: 28px; height: 28px; justify-content: center; }
            .nav-badge { padding: 5px 10px; font-size: 0.68rem; }
        }

        /* ─── PARTICLES ─── */
        .particles {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(212, 168, 71, 0.3);
            animation: particle-float linear infinite;
        }
        @keyframes particle-float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }

        /* ─── DONATION FORM (inside modal) ─── */
        #donationMethod {
            width: 100%;
            padding: 14px 18px;
            background: rgba(45, 31, 26, 0.5);
            border: 1px solid rgba(212, 168, 71, 0.12);
            border-radius: 12px;
            color: #e8ddd9;
            font-family: inherit;
            font-size: 0.95rem;
            outline: none;
        }
        #donationAmount {
            width: 100%;
            padding: 14px 18px;
            background: rgba(45, 31, 26, 0.5);
            border: 1px solid rgba(212, 168, 71, 0.12);
            border-radius: 12px;
            color: #e8ddd9;
            font-family: inherit;
            font-size: 0.95rem;
            outline: none;
        }
        #donationAmount:focus, #donationMethod:focus {
            border-color: rgba(212, 168, 71, 0.4);
            box-shadow: 0 0 0 3px rgba(212, 168, 71, 0.08);
        }
        #bankDetails, #qrisDetails {
            background: rgba(45, 31, 26, 0.4);
            border: 1px solid rgba(212, 168, 71, 0.15);
            border-radius: 12px;
            padding: 20px;
            margin-top: 16px;
            text-align: center;
        }
        #bankDetails p, #qrisDetails p { color: #9e8a82; font-size: 0.875rem; }
        #bankDetails .bank-num { font-size: 1.5rem; font-weight: 800; color: var(--gold); letter-spacing: 2px; }

        /* Divider ornament */
        .ornament {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 0 auto;
            width: fit-content;
        }
        .ornament-line { height: 1px; width: 60px; background: linear-gradient(90deg, transparent, rgba(212,168,71,0.4), transparent); }
        .ornament-diamond {
            width: 8px; height: 8px;
            background: var(--gold);
            transform: rotate(45deg);
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <div class="navbar-inner">
        <a href="#" class="navbar-logo" aria-label="Kowpi.id">
            <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="Kowpi.id">
        </a>
        <div class="navbar-actions">
            <a href="https://kowpi.id" class="nav-back" title="Kembali ke Kowpi.id">
                <i data-lucide="arrow-left" style="width:14px;height:14px;flex-shrink:0;"></i>
                <span class="nav-back-text">Kembali ke Home</span>
            </a>
            <a href="#download-form" class="nav-badge">
                <span class="nav-badge-full">Ambil Ebook Gratis →</span>
                <span class="nav-badge-short">Ambil Ebook →</span>
            </a>
        </div>
    </div>
</nav>

<?= $this->renderSection('content') ?>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="footer-inner">
            <a href="#" class="footer-logo">
                <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="Kowpi.id" style="height:28px; width:auto; opacity:0.8;">
            </a>
            <div class="footer-copy">&copy; <?= date('Y') ?> Kowpi.id. Hak Cipta Dilindungi.</div>
        </div>
        <p class="footer-disclaimer">Disclaimer: Data yang Anda berikan dijaga kerahasiaannya dan tidak akan diperjualbelikan kepada pihak manapun. Ebook ini dibagikan semata-mata untuk kepentingan dakwah dan edukasi.</p>
    </div>
</footer>

<!-- AOS Script -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<!-- Main JS -->
<script src="<?= base_url('js/main.js?v=' . filemtime(FCPATH . 'js/main.js')) ?>"></script>

<script>
    // Handle Rentang Umur dropdown change
    function handleRentangUmurChange(select) {
        var otherWrap = document.getElementById('rentangUmurOtherWrap');
        var otherInput = document.getElementById('rentang_umur_other');
        if (!otherWrap) return;
        var val = select ? select.value : '';
        if (val === 'Lainnya') {
            otherWrap.classList.remove('hidden');
            otherWrap.style.setProperty('display', 'block', 'important');
            if (otherInput) {
                otherInput.setAttribute('required', 'required');
                setTimeout(function () { otherInput.focus(); }, 50);
            }
        } else {
            otherWrap.classList.add('hidden');
            otherWrap.style.setProperty('display', 'none', 'important');
            if (otherInput) {
                otherInput.removeAttribute('required');
                otherInput.value = '';
            }
        }
    }
    window.handleRentangUmurChange = handleRentangUmurChange;

    // Init Lucide icons safely
    try {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    } catch (e) {
        console.warn('Lucide init warning:', e);
    }

    // Init AOS safely
    try {
        if (typeof AOS !== 'undefined') {
            AOS.init({ duration: 700, once: true, offset: 60, easing: 'ease-out-cubic' });
        }
    } catch (e) {
        console.warn('AOS init warning:', e);
    }

    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });
    }

    // Particle generator
    function createParticles(container, count) {
        if (!container) return;
        for (let i = 0; i < count; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            const size = Math.random() * 4 + 1;
            p.style.cssText = `
                width: ${size}px; height: ${size}px;
                left: ${Math.random() * 100}%;
                animation-duration: ${Math.random() * 15 + 10}s;
                animation-delay: ${Math.random() * 10}s;
                opacity: ${Math.random() * 0.5 + 0.1};
            `;
            container.appendChild(p);
        }
    }
    try {
        document.querySelectorAll('.particles').forEach(c => createParticles(c, 15));
    } catch (e) {}
</script>

</body>
</html>
