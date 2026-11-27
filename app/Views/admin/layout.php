<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Admin' ?> - Kowpi.id</title>
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-kowpi.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        :root {
            --brand-50: #fcf8f7;
            --brand-100: #f5ebe8;
            --brand-500: #8c4835;
            --brand-600: #723a2a;
            --brand-700: #582a1d;
            --brand-800: #3e1b12;
            --brand-900: #2a110a;
            --brand-950: #150805;
            --gold: #d4a847;
            --gold-light: #f5d77f;
            --gold-dark: #aa812c;
            --gold-glow: rgba(212, 168, 71, 0.25);
            --sidebar-bg: #140d0b;
            --sidebar-border: #261713;
            --sidebar-hover: #221512;
            --body-bg: #f8f6f3;
            --card-bg: #ffffff;
            --text-dark: #1f1411;
            --text-muted: #7c6f6b;
            --border-light: #ede8e3;
            --success: #10b981;
            --success-bg: #ecfdf5;
            --info: #3b82f6;
            --info-bg: #eff6ff;
            --warning: #f59e0b;
            --warning-bg: #fffbeb;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            padding: 24px;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            gap: 14px;
            background: linear-gradient(180deg, rgba(140, 72, 53, 0.12) 0%, transparent 100%);
        }

        .sidebar-brand img {
            height: 38px;
            width: auto;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.4));
        }

        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.15rem;
            color: #ffffff;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .sidebar-brand-badge {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gold-light);
            font-weight: 700;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #6a5751;
            padding: 12px 14px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #ab9b95;
            text-decoration: none;
            border-radius: 12px;
            font-size: 0.92rem;
            font-weight: 600;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-item:hover {
            color: #ffffff;
            background: var(--sidebar-hover);
            transform: translateX(3px);
        }

        .nav-item.active {
            color: #ffffff;
            background: linear-gradient(135deg, var(--brand-700), var(--brand-600));
            box-shadow: 0 4px 16px rgba(140, 72, 53, 0.4);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 4px;
            background: var(--gold);
            border-radius: 0 4px 4px 0;
        }

        .nav-item i {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            background: rgba(212, 168, 71, 0.18);
            color: var(--gold-light);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 10px;
            border: 1px solid rgba(212, 168, 71, 0.25);
        }

        .sidebar-footer {
            padding: 18px 20px;
            border-top: 1px solid var(--sidebar-border);
            background: rgba(15, 9, 8, 0.6);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--brand-500), var(--gold-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .user-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .user-name {
            color: #ffffff;
            font-size: 0.88rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            color: var(--gold);
            font-size: 0.72rem;
            font-weight: 600;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.2);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #fecaca;
            border-color: rgba(239, 68, 68, 0.4);
            transform: translateY(-1px);
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: 280px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: calc(100% - 280px);
        }

        /* Top Header */
        .topbar {
            height: 72px;
            background: #ffffff;
            border-bottom: 1px solid var(--border-light);
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-toggle-sidebar {
            display: none;
            background: none;
            border: 1px solid var(--border-light);
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            color: var(--text-dark);
        }

        .topbar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.3px;
        }

        .topbar-date {
            font-size: 0.82rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-header-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-view-site {
            background: var(--brand-50);
            color: var(--brand-700);
            border: 1px solid var(--brand-100);
        }

        .btn-view-site:hover {
            background: var(--brand-100);
            color: var(--brand-900);
            transform: translateY(-1px);
        }

        .btn-header-export {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #ffffff;
            border: none;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        .btn-header-export:hover {
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
            transform: translateY(-1px);
            color: #ffffff;
        }

        .btn-header-export-donations {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: #ffffff;
            border: none;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);
        }

        .btn-header-export-donations:hover {
            box-shadow: 0 6px 16px rgba(217, 119, 6, 0.4);
            transform: translateY(-1px);
            color: #ffffff;
        }

        /* Content Container */
        .content-container {
            padding: 32px;
            flex: 1;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
            z-index: 90;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .sidebar-overlay.show {
                display: block;
            }
            .main-wrapper {
                margin-left: 0;
                width: 100%;
            }
            .btn-toggle-sidebar {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .topbar {
                padding: 0 20px;
            }
            .content-container {
                padding: 20px 16px;
            }
            .btn-view-site span {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="Kowpi.id">
            <div class="sidebar-brand-text">
                <div class="sidebar-brand-title">KOWPI</div>
                <div class="sidebar-brand-badge">Admin Dashboard</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>
            <a href="<?= base_url('admin') ?>" class="nav-item active" id="navDashboard">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
            
            <div class="nav-label">Data & Export</div>
            <a href="<?= base_url('admin/export-leads') ?>" class="nav-item" id="navExportLeads" title="Download Excel data pendaftar">
                <i data-lucide="file-spreadsheet" style="color: #34d399;"></i>
                <span>Export Excel Leads</span>
                <span class="nav-badge">XLS</span>
            </a>
            <a href="<?= base_url('admin/export-donations') ?>" class="nav-item" id="navExportDonations" title="Download Excel rekap donasi">
                <i data-lucide="file-spreadsheet" style="color: #fbbf24;"></i>
                <span>Export Excel Donasi</span>
                <span class="nav-badge" style="background:rgba(217, 119, 6, 0.2); color:#fbbf24; border-color:rgba(217, 119, 6, 0.3);">XLS</span>
            </a>

            <div class="nav-label">Konten Ebook</div>
            <a href="<?= base_url('admin#sectionEbook') ?>" class="nav-item" id="navEbookFile" title="Kelola file PDF ebook">
                <i data-lucide="file-text" style="color: #f87171;"></i>
                <span>Upload File Ebook</span>
                <span class="nav-badge" style="background:rgba(239, 68, 68, 0.2); color:#fca5a5; border-color:rgba(239, 68, 68, 0.3);">PDF</span>
            </a>

            <div class="nav-label">Tautan Luar</div>
            <a href="<?= base_url() ?>" target="_blank" class="nav-item" id="navLandingPage">
                <i data-lucide="external-link" style="color: var(--gold-light);"></i>
                <span>Lihat Landing Page</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">
                    <?= strtoupper(substr(session()->get('username') ?? 'A', 0, 1)) ?>
                </div>
                <div class="user-info">
                    <span class="user-name"><?= esc(session()->get('username') ?? 'Admin') ?></span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>
            <a href="<?= base_url('admin/logout') ?>" class="btn-logout" id="btnLogout">
                <i data-lucide="log-out" style="width: 16px; height: 16px;"></i>
                <span>Keluar (Logout)</span>
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navigation -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="btn-toggle-sidebar" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
                    <i data-lucide="menu" style="width: 22px; height: 22px;"></i>
                </button>
                <div>
                    <h1 class="topbar-title"><?= $title ?? 'Ringkasan Dashboard' ?></h1>
                    <div class="topbar-date">
                        <i data-lucide="calendar" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                        <?= date('d F Y') ?>
                    </div>
                </div>
            </div>

            <div class="topbar-right">
                <a href="<?= base_url() ?>" target="_blank" class="btn-header-action btn-view-site" title="Buka Landing Page Utama">
                    <i data-lucide="globe" style="width: 16px; height: 16px;"></i>
                    <span>Pratinjau Web</span>
                </a>
                <a href="<?= base_url('admin/export-leads') ?>" class="btn-header-action btn-header-export" id="btnExportTopLeads" title="Export Excel Data Leads">
                    <i data-lucide="download" style="width: 15px; height: 15px;"></i>
                    <span>Excel Leads</span>
                </a>
                <a href="<?= base_url('admin/export-donations') ?>" class="btn-header-action btn-header-export-donations" id="btnExportTopDonations" title="Export Excel Rekap Donasi">
                    <i data-lucide="download" style="width: 15px; height: 15px;"></i>
                    <span>Excel Donasi</span>
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content-container">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script>
        lucide.createIcons();

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    </script>
</body>
</html>
