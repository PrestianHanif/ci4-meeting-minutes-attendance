<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Dashboard - Kowpi.id<?= $this->endSection() ?>

<?= $this->section('header_title') ?>Dashboard Overview<?= $this->endSection() ?>
<?= $this->section('header_subtitle') ?>Pantau data pengunduh buku, intensi donasi, dan unduh laporan secara realtime.<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    /* 4 Stat Overview Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(44, 24, 16, 0.04);
        border: 1px solid var(--border-light);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(44, 24, 16, 0.08);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .card-leads::before { background: linear-gradient(90deg, var(--brand-500), var(--brand-700)); }
    .card-today::before { background: linear-gradient(90deg, #10b981, #059669); }
    .card-visitors::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .card-donations::before { background: linear-gradient(90deg, #f59e0b, #d97706); }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.1;
        font-family: 'Playfair Display', serif;
    }

    .stat-meta {
        margin-top: 10px;
        font-size: 0.8rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stat-badge-today {
        background: #ecfdf5;
        color: #059669;
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .icon-leads { background: rgba(140, 72, 53, 0.1); color: var(--brand-600); }
    .icon-today { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .icon-visitors { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
    .icon-donations { background: rgba(245, 158, 11, 0.1); color: #d97706; }

    /* Modern Data Card Container */
    .data-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(44, 24, 16, 0.04);
        border: 1px solid var(--border-light);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .data-card-header {
        padding: 20px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        border-bottom: 1px solid var(--border-light);
        background: #ffffff;
    }

    .data-card-title-wrap {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .data-card-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .data-card-subtitle {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin: 0;
    }

    .data-card-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Table Search Input */
    .table-search-box {
        position: relative;
        display: flex;
        align-items: center;
        width: 270px;
        max-width: 100%;
    }

    .search-icon-wrapper {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        color: #9c8a84;
        z-index: 2;
        line-height: 0;
    }

    .search-icon-wrapper svg,
    .search-icon-wrapper i {
        width: 16px;
        height: 16px;
        display: block;
    }

    .table-search-input {
        width: 100%;
        height: 40px;
        padding: 0 14px 0 38px;
        border: 1.5px solid var(--border-light);
        background: #ffffff;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.86rem;
        color: var(--text-dark);
        outline: none;
        line-height: 40px;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .table-search-input:focus {
        border-color: var(--brand-500);
        box-shadow: 0 0 0 3px rgba(140, 72, 53, 0.12);
    }

    .table-search-input::placeholder {
        color: #a89a95;
    }

    /* Export Excel Button */
    .btn-export-excel {
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 18px;
        background: linear-gradient(135deg, #059669, #10b981);
        color: #ffffff;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        box-sizing: border-box;
        white-space: nowrap;
    }

    .btn-export-excel:hover {
        background: linear-gradient(135deg, #047857, #059669);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        transform: translateY(-1px);
        color: #ffffff;
    }

    .btn-export-amber {
        background: linear-gradient(135deg, #d97706, #f59e0b);
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);
    }

    .btn-export-amber:hover {
        background: linear-gradient(135deg, #b45309, #d97706);
        box-shadow: 0 6px 16px rgba(217, 119, 6, 0.35);
        color: #ffffff;
    }

    .btn-export-excel svg,
    .btn-export-excel i {
        width: 16px;
        height: 16px;
    }

    /* Table Component */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.88rem;
    }

    .modern-table thead {
        background: #fbf9f7;
        border-bottom: 2px solid var(--border-light);
    }

    .modern-table th {
        padding: 14px 20px;
        font-weight: 700;
        color: #5c4c47;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .modern-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
        color: var(--text-dark);
    }

    .modern-table tbody tr {
        transition: background-color 0.15s;
    }

    .modern-table tbody tr:hover {
        background-color: #faf7f4;
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Cell styles */
    .lead-name-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .lead-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--brand-100), #edd8d0);
        color: var(--brand-700);
        font-weight: 700;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .lead-name-text {
        font-weight: 600;
        color: var(--text-dark);
    }

    .whatsapp-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #059669;
        text-decoration: none;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        background: #ecfdf5;
        transition: all 0.2s;
        font-size: 0.82rem;
    }

    .whatsapp-link:hover {
        background: #d1fae5;
        color: #047857;
    }

    .badge-job {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        background: #f3f0ec;
        color: #5a4b46;
        border: 1px solid #e5dfd8;
        white-space: nowrap;
    }

    .badge-date {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #4a3d39;
        font-size: 0.82rem;
        font-weight: 500;
    }

    .badge-status-pending {
        background: #fef3c7;
        color: #92400e;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-status-success {
        background: #d1fae5;
        color: #065f46;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-status-cancelled {
        background: #f1f5f9;
        color: #64748b;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    #donationsTable th,
    #donationsTable td {
        padding: 13px 12px;
    }

    /* Action buttons in donation table */
    .btn-action-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-act {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.77rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        white-space: nowrap;
        font-family: inherit;
    }
    .btn-act:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        pointer-events: none;
    }

    .btn-act-success {
        background: #ecfdf5;
        color: #047857;
        border-color: #a7f3d0;
    }
    .btn-act-success:hover {
        background: #059669;
        color: #ffffff;
        border-color: #059669;
        box-shadow: 0 3px 8px rgba(5, 150, 105, 0.25);
        transform: translateY(-1px);
    }

    .btn-act-pending {
        background: #fffbeb;
        color: #b45309;
        border-color: #fde68a;
    }
    .btn-act-pending:hover {
        background: #d97706;
        color: #ffffff;
        border-color: #d97706;
        box-shadow: 0 3px 8px rgba(217, 119, 6, 0.25);
        transform: translateY(-1px);
    }

    .btn-act-cancel {
        background: #f8fafc;
        color: #64748b;
        border-color: #e2e8f0;
        padding: 6px 9px;
    }
    .btn-act-cancel:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
        box-shadow: 0 3px 8px rgba(239, 68, 68, 0.25);
        transform: translateY(-1px);
    }

    .btn-act-delete {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }
    .btn-act-delete:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
        box-shadow: 0 3px 8px rgba(220, 38, 38, 0.25);
        transform: translateY(-1px);
    }

    /* Admin Floating Toast */
    .admin-toast-container {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }

    .admin-toast {
        pointer-events: auto;
        min-width: 280px;
        max-width: 420px;
        padding: 12px 18px;
        border-radius: 12px;
        background: #1e1b18;
        color: #ffffff;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.85rem;
        font-weight: 500;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .admin-toast.show {
        transform: translateY(0);
        opacity: 1;
    }
    .admin-toast-success {
        border-left: 4px solid #10b981;
    }
    .admin-toast-danger {
        border-left: 4px solid #ef4444;
    }

    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: var(--text-muted);
    }

    .empty-state-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--brand-50);
        color: var(--brand-500);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }

    /* Counter footer */
    .table-footer-info {
        padding: 14px 28px;
        background: #fbf9f7;
        border-top: 1px solid var(--border-light);
        font-size: 0.82rem;
        color: var(--text-muted);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Alert Banners */
    .alert-banner {
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        animation: slideDown 0.3s ease;
    }
    .alert-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
    }
    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    /* Ebook Management Card */
    .ebook-manage-body {
        padding: 24px 28px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        background: #ffffff;
    }
    @media (max-width: 900px) {
        .ebook-manage-body {
            grid-template-columns: 1fr;
        }
    }

    .badge-file-active {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        color: #059669;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #a7f3d0;
    }
    .badge-file-missing {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef2f2;
        color: #b91c1c;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #fecaca;
    }

    .ebook-info-box {
        background: #faf8f5;
        border: 1px solid var(--border-light);
        border-radius: 14px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        justify-content: space-between;
    }
    .pdf-icon-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fee2e2;
        color: #dc2626;
        padding: 4px 10px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.75rem;
        width: fit-content;
    }
    .pdf-icon-badge svg,
    .pdf-icon-badge i {
        width: 14px;
        height: 14px;
    }
    .ebook-info-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-top: 6px;
        word-break: break-all;
    }
    .ebook-info-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-top: 8px;
    }
    .ebook-info-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .ebook-info-meta svg,
    .ebook-info-meta i {
        width: 14px;
        height: 14px;
        color: var(--brand-600);
    }
    .btn-preview-file {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 18px;
        background: #ffffff;
        color: var(--brand-700);
        border: 1.5px solid var(--brand-500);
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        width: fit-content;
    }
    .btn-preview-file:hover {
        background: var(--brand-500);
        color: #ffffff;
        transform: translateY(-1px);
    }
    .btn-download-file {
        background: linear-gradient(135deg, var(--brand-700), var(--brand-800));
        color: #ffffff;
        border-color: var(--brand-700);
    }
    .btn-download-file:hover {
        background: linear-gradient(135deg, var(--brand-600), var(--brand-700));
        border-color: var(--brand-600);
        color: #ffffff;
    }

    /* Upload Box */
    .ebook-upload-box {
        display: flex;
        flex-direction: column;
    }
    .file-drop-zone {
        border: 2px dashed #d1c7c2;
        border-radius: 14px;
        padding: 24px 20px;
        text-align: center;
        background: #faf8f5;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
    }
    .file-drop-zone:hover,
    .file-drop-zone.drag-active {
        border-color: var(--brand-500);
        background: #fdf3f0;
    }
    .file-drop-zone input[type="file"] {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 5;
    }
    .btn-browse-file {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: #ffffff;
        border: 1.5px solid #d6c6bf;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--brand-700);
        margin-top: 6px;
        pointer-events: none;
        transition: all 0.2s;
    }
    .file-drop-zone:hover .btn-browse-file {
        border-color: var(--brand-500);
        background: var(--brand-50);
    }
    .drop-zone-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f3ece8;
        color: var(--brand-600);
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }
    .drop-zone-icon svg,
    .drop-zone-icon i {
        width: 22px;
        height: 22px;
    }
    .drop-zone-prompt {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-dark);
        pointer-events: none;
    }
    .drop-zone-sub {
        display: block;
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-top: 2px;
        pointer-events: none;
    }
    .selected-file-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        margin-top: 6px;
        max-width: 90%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        pointer-events: none;
    }
    .selected-file-badge.hidden {
        display: none !important;
    }
    .btn-submit-upload {
        margin-top: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px 20px;
        background: linear-gradient(135deg, var(--brand-600), var(--brand-700));
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(140, 72, 53, 0.3);
        transition: all 0.2s;
    }
    .btn-submit-upload:hover {
        background: linear-gradient(135deg, var(--brand-500), var(--brand-600));
        box-shadow: 0 6px 18px rgba(140, 72, 53, 0.45);
        transform: translateY(-1px);
    }
    .spin-icon {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* PDF Preview Modal */
    .pdf-modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(18, 11, 9, 0.75);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .pdf-modal-backdrop.show {
        display: flex;
        opacity: 1;
    }
    .pdf-modal-dialog {
        width: 100%;
        max-width: 1050px;
        height: 90vh;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid var(--border-light);
        transform: scale(0.95);
        transition: transform 0.25s ease;
    }
    .pdf-modal-backdrop.show .pdf-modal-dialog {
        transform: scale(1);
    }
    .pdf-modal-header {
        padding: 16px 22px;
        background: #faf8f5;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-shrink: 0;
    }
    .pdf-modal-title-wrap {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }
    .pdf-modal-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 480px;
    }
    .pdf-modal-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    .btn-modal-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: var(--brand-700);
        color: #ffffff;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-modal-action:hover {
        background: var(--brand-600);
        color: #ffffff;
    }
    .btn-modal-external {
        background: #ffffff;
        color: var(--text-dark);
        border: 1px solid var(--border-light);
        padding: 8px 10px;
    }
    .btn-modal-external:hover {
        background: #f3ece8;
        color: var(--brand-700);
    }
    .btn-modal-close {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid var(--border-light);
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-modal-close:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
    }
    .pdf-modal-body {
        flex: 1;
        width: 100%;
        height: 100%;
        background: #525659;
        overflow: hidden;
        position: relative;
    }
    .pdf-iframe {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }

    /* Confirm Delete Modal */
    .confirm-modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(18, 11, 9, 0.72);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .confirm-modal-backdrop.show {
        display: flex;
        opacity: 1;
    }
    .confirm-modal-dialog {
        width: 100%;
        max-width: 440px;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid var(--border-light);
        transform: scale(0.95);
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .confirm-modal-backdrop.show .confirm-modal-dialog {
        transform: scale(1);
    }
    .confirm-modal-header {
        padding: 22px 24px 16px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        position: relative;
    }
    .confirm-modal-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #fee2e2;
    }
    .confirm-modal-icon i, .confirm-modal-icon svg {
        width: 22px;
        height: 22px;
    }
    .confirm-modal-title-wrap {
        flex: 1;
    }
    .confirm-modal-title {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-dark);
    }
    .confirm-modal-subtitle {
        margin: 4px 0 0;
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.4;
    }
    .confirm-modal-body {
        padding: 0 24px 20px;
    }
    .delete-target-card {
        background: #faf7f5;
        border: 1px solid var(--border-light);
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    .delete-target-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.15), rgba(239, 68, 68, 0.25));
        color: #dc2626;
        font-weight: 800;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .delete-target-info {
        min-width: 0;
        flex: 1;
    }
    .delete-target-name {
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--text-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .delete-target-email {
        font-size: 0.78rem;
        color: var(--text-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .delete-warning-text {
        margin: 0;
        font-size: 0.78rem;
        color: #b91c1c;
        background: #fef2f2;
        border-radius: 8px;
        padding: 8px 12px;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        line-height: 1.4;
        border: 1px solid #fee2e2;
    }
    .confirm-modal-footer {
        padding: 14px 24px 20px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        border-top: 1px solid var(--border-light);
    }
    .btn-confirm-cancel {
        padding: 9px 18px;
        background: #f3f4f6;
        color: #4b5563;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
    }
    .btn-confirm-cancel:hover {
        background: #e5e7eb;
        color: #1f2937;
    }
    .btn-confirm-delete {
        padding: 9px 18px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        box-shadow: 0 3px 10px rgba(220, 38, 38, 0.3);
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: inherit;
    }
    .btn-confirm-delete:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.4);
        transform: translateY(-1px);
    }
    .btn-confirm-delete:disabled {
        opacity: 0.7;
        cursor: wait;
        transform: none;
    }
</style>

<!-- Flash Notifications -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-banner alert-success">
        <i data-lucide="check-circle-2" style="width:20px;height:20px;flex-shrink:0;"></i>
        <span><?= esc(session()->getFlashdata('success')) ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert-banner alert-danger">
        <i data-lucide="alert-circle" style="width:20px;height:20px;flex-shrink:0;"></i>
        <span><?= esc(session()->getFlashdata('error')) ?></span>
    </div>
<?php endif; ?>

<!-- 4 Key Metrics Overview -->
<div class="stats-grid">
    <!-- Stat 1: Total Leads -->
    <div class="stat-card card-leads">
        <div class="stat-info">
            <span class="stat-label">Total Leads</span>
            <span class="stat-value" id="statTotalLeads"><?= number_format($total_leads) ?></span>
            <div class="stat-meta">
                <i data-lucide="book-open" style="width:14px;height:14px;"></i>
                <span>Pengunduh Ebook</span>
            </div>
        </div>
        <div class="stat-icon-wrapper icon-leads">
            <i data-lucide="users" style="width:24px;height:24px;"></i>
        </div>
    </div>

    <!-- Stat 2: Leads Hari Ini -->
    <div class="stat-card card-today">
        <div class="stat-info">
            <span class="stat-label">Leads Hari Ini</span>
            <span class="stat-value" id="statLeadsToday"><?= number_format($leads_today) ?></span>
            <div class="stat-meta">
                <span class="stat-badge-today">
                    <i data-lucide="trending-up" style="width:12px;height:12px;"></i>
                    Baru Masuk
                </span>
            </div>
        </div>
        <div class="stat-icon-wrapper icon-today">
            <i data-lucide="user-plus" style="width:24px;height:24px;"></i>
        </div>
    </div>

    <!-- Stat 3: Total Pengunjung -->
    <div class="stat-card card-visitors">
        <div class="stat-info">
            <span class="stat-label">Total Pengunjung</span>
            <span class="stat-value"><?= number_format($total_visitors) ?></span>
            <div class="stat-meta">
                <i data-lucide="eye" style="width:14px;height:14px;"></i>
                <span><?= number_format($visitors_today) ?> pengunjung hari ini</span>
            </div>
        </div>
        <div class="stat-icon-wrapper icon-visitors">
            <i data-lucide="activity" style="width:24px;height:24px;"></i>
        </div>
    </div>

    <!-- Stat 4: Total Donasi -->
    <div class="stat-card card-donations">
        <div class="stat-info">
            <span class="stat-label">Intensi Donasi</span>
            <span class="stat-value" id="statDonationTotal" style="font-size:1.55rem;">Rp <?= number_format($total_donations, 0, ',', '.') ?></span>
            <div class="stat-meta">
                <i data-lucide="check-circle-2" style="width:14px;height:14px;color:#059669;"></i>
                <span id="statDonationSuccessMeta"><strong id="statDonationSuccessCount" style="color:#065f46;"><?= $count_donations_success ?></strong> valid (Rp <span id="statDonationSuccessVal"><?= number_format($total_donations_success, 0, ',', '.') ?></span>) • <strong id="statDonationPendingCount" style="color:#b45309;"><?= $count_donations_pending ?></strong> menunggu</span>
            </div>
        </div>
        <div class="stat-icon-wrapper icon-donations">
            <i data-lucide="heart-handshake" style="width:24px;height:24px;"></i>
        </div>
    </div>
</div>

<!-- Ebook PDF Management Card -->
<div class="data-card" id="sectionEbook" style="margin-bottom: 30px;">
    <div class="data-card-header">
        <div class="data-card-title-wrap">
            <h2 class="data-card-title">
                <i data-lucide="file-text" style="color:var(--brand-600);width:20px;height:20px;"></i>
                Manajemen File Ebook (PDF)
            </h2>
            <p class="data-card-subtitle">
                File buku panduan yang otomatis dibagikan kepada pendaftar & dikirimkan via email.
            </p>
        </div>
        <div>
            <?php if (!empty($ebook_info['exists'])): ?>
                <span class="badge-file-active">
                    <i data-lucide="check-circle" style="width:14px;height:14px;"></i>
                    File Aktif Tersedia
                </span>
            <?php else: ?>
                <span class="badge-file-missing">
                    <i data-lucide="alert-triangle" style="width:14px;height:14px;"></i>
                    File Belum Ada
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="ebook-manage-body">
        <!-- Current File Info Box -->
        <div class="ebook-info-box">
            <div>
                <span class="pdf-icon-badge">
                    <i data-lucide="file-check"></i>
                    PDF AKTIF SAAT INI
                </span>
                <div class="ebook-info-name" id="currentEbookTitle" style="word-break:break-word; margin-top:10px; font-size:1.15rem; font-weight:800; color:var(--text-dark);">
                    <?= esc($ebook_info['filename'] ?? 'panduan-fikih-harta-anak-yatim.pdf') ?>
                </div>
                <div class="ebook-info-meta">
                    <span>
                        <i data-lucide="hard-drive"></i>
                        Ukuran: <strong><?= esc($ebook_info['filesize'] ?? $ebook_info['size'] ?? '-') ?></strong>
                    </span>
                    <span>
                        <i data-lucide="calendar"></i>
                        Update: <strong><?= esc($ebook_info['updated_at'] ?? '-') ?></strong>
                    </span>
                </div>
            </div>

            <?php if (!empty($ebook_info['exists'])): ?>
                <div style="margin-top: 18px; display: flex; gap: 10px; flex-wrap: wrap;">
                    <button type="button" class="btn-preview-file" id="btnPreviewEbook" onclick="openPdfModal()" title="Buka preview dokumen PDF dalam popup modal">
                        <i data-lucide="eye" style="width:16px;height:16px;"></i>
                        <span>Lihat Preview</span>
                    </button>
                    <a href="<?= esc($ebook_info['download_url'] ?? $ebook_info['url']) ?>" class="btn-preview-file btn-download-file" id="btnDownloadEbook" title="Unduh file PDF langsung ke komputer">
                        <i data-lucide="download" style="width:16px;height:16px;"></i>
                        <span>Download PDF</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Upload New PDF Form -->
        <div class="ebook-upload-box">
            <form action="<?= site_url('admin/upload-ebook') ?>" method="POST" enctype="multipart/form-data" id="ebookUploadForm" onsubmit="return handleEbookFormSubmit(event)">
                <?= csrf_field() ?>
                
                <div class="file-drop-zone" id="dropZoneContainer">
                    <input type="file" name="ebook_file" id="ebookFile" accept=".pdf,application/pdf" onchange="handleEbookFileSelect(this)">
                    <div class="drop-zone-icon">
                        <i data-lucide="upload-cloud"></i>
                    </div>
                    <span class="drop-zone-prompt" id="dropZoneTitle">Klik atau seret file PDF baru ke sini</span>
                    <span class="drop-zone-sub">Maksimal 30 MB &bull; Format dokumen .PDF resmi</span>
                    <span class="btn-browse-file">
                        <i data-lucide="folder-open" style="width:14px;height:14px;"></i>
                        Pilih File PDF dari Komputer
                    </span>
                    <div class="selected-file-badge hidden" id="selectedFileBadge">
                        <i data-lucide="file-check" style="width:14px;height:14px;"></i>
                        <span id="selectedFileName">Belum ada file dipilih</span>
                    </div>
                </div>

                <button type="submit" class="btn-submit-upload" id="btnSubmitEbook">
                    <i data-lucide="upload" style="width:18px;height:18px;"></i>
                    <span id="btnSubmitText">Upload & Perbarui Ebook</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Popup Preview Ebook PDF -->
<div class="pdf-modal-backdrop" id="pdfModal" onclick="handlePdfModalBackdropClick(event)">
    <div class="pdf-modal-dialog">
        <div class="pdf-modal-header">
            <div class="pdf-modal-title-wrap">
                <span class="pdf-icon-badge" style="margin:0;">
                    <i data-lucide="file-text"></i>
                    PREVIEW PDF
                </span>
                <div style="min-width:0;">
                    <h3 class="pdf-modal-title"><?= esc($ebook_info['filename'] ?? 'Dokumen PDF') ?></h3>
                    <div style="font-size:0.75rem; color:#8c7a74; display:flex; gap:12px; margin-top:2px;">
                        <span>Ukuran: <strong><?= esc($ebook_info['filesize'] ?? '-') ?></strong></span>
                        <span>Diperbarui: <strong><?= esc($ebook_info['updated_at'] ?? '-') ?></strong></span>
                    </div>
                </div>
            </div>
            <div class="pdf-modal-actions">
                <a href="<?= esc($ebook_info['download_url'] ?? $ebook_info['url']) ?>" class="btn-modal-action" title="Download file PDF ke komputer">
                    <i data-lucide="download" style="width:15px;height:15px;"></i>
                    <span>Download</span>
                </a>
                <a href="<?= esc($ebook_info['url']) ?>" target="_blank" class="btn-modal-action btn-modal-external" title="Buka di tab terpisah">
                    <i data-lucide="external-link" style="width:15px;height:15px;"></i>
                </a>
                <button type="button" class="btn-modal-close" onclick="closePdfModal()" title="Tutup preview (Esc)">
                    <i data-lucide="x" style="width:18px;height:18px;"></i>
                </button>
            </div>
        </div>

        <div class="pdf-modal-body">
            <?php if(!empty($ebook_info['exists'])): ?>
                <iframe src="<?= esc($ebook_info['url']) ?>" class="pdf-iframe" id="pdfIframe" title="PDF Preview"></iframe>
            <?php else: ?>
                <div style="display:flex; align-items:center; justify-content:center; height:100%; color:#ffffff; font-size:0.95rem;">
                    File PDF belum diunggah.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Popup Konfirmasi Hapus Lead -->
<div class="confirm-modal-backdrop" id="deleteLeadModal" onclick="handleDeleteModalBackdropClick(event)">
    <div class="confirm-modal-dialog">
        <div class="confirm-modal-header">
            <div class="confirm-modal-icon">
                <i data-lucide="alert-triangle"></i>
            </div>
            <div class="confirm-modal-title-wrap">
                <h3 class="confirm-modal-title">Hapus Data Leads?</h3>
                <p class="confirm-modal-subtitle">Tindakan ini akan menghapus data pendaftar secara permanen.</p>
            </div>
            <button type="button" class="btn-modal-close" onclick="closeDeleteLeadModal()" title="Tutup (Esc)">
                <i data-lucide="x" style="width:18px;height:18px;"></i>
            </button>
        </div>

        <div class="confirm-modal-body">
            <div class="delete-target-card">
                <div class="delete-target-avatar" id="deleteTargetAvatar">A</div>
                <div class="delete-target-info">
                    <div class="delete-target-name" id="deleteTargetName">-</div>
                    <div class="delete-target-email" id="deleteTargetEmail">-</div>
                </div>
            </div>
            <p class="delete-warning-text">
                <i data-lucide="info" style="width:14px;height:14px;color:#dc2626;flex-shrink:0;margin-top:1px;"></i>
                <span>Data leads dan riwayat intensi donasi yang terhubung dengan kontak ini akan otomatis dihapus dari sistem.</span>
            </p>
        </div>

        <div class="confirm-modal-footer">
            <button type="button" class="btn-confirm-cancel" onclick="closeDeleteLeadModal()">
                Batal
            </button>
            <button type="button" class="btn-confirm-delete" id="btnConfirmDeleteLead" onclick="confirmDeleteLeadSubmit()">
                <i data-lucide="trash-2" style="width:15px;height:15px;"></i>
                <span id="btnConfirmDeleteText">Ya, Hapus Data</span>
            </button>
        </div>
    </div>
</div>

<!-- Main Table: Leads Pengunduh Ebook -->
<div class="data-card" id="sectionLeads">
    <div class="data-card-header">
        <div class="data-card-title-wrap">
            <h2 class="data-card-title">
                <i data-lucide="database" style="color:var(--brand-600);width:20px;height:20px;"></i>
                Data Leads Pengunduh Ebook
            </h2>
            <p class="data-card-subtitle">
                Data kontak peminat buku panduan yatim, lengkap dengan tanggal lahir & pekerjaan.
            </p>
        </div>

        <div class="data-card-actions">
            <!-- Client Search Box -->
            <div class="table-search-box">
                <span class="search-icon-wrapper">
                    <i data-lucide="search"></i>
                </span>
                <input type="text" id="leadSearch" class="table-search-input" placeholder="Cari nama, email, no WA, pekerjaan..." oninput="filterLeads()">
            </div>

            <!-- Export to Excel Button -->
            <a href="<?= site_url('admin/export-leads') ?>" class="btn-export-excel" id="btnExportLeads" title="Download data pendaftar dalam format Excel (.xls)">
                <i data-lucide="file-spreadsheet"></i>
                <span>Export Excel Leads (.xls)</span>
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="modern-table" id="leadsTable">
            <thead>
                <tr>
                    <th style="width: 50px; text-align:center;">#</th>
                    <th>Nama Lengkap</th>
                    <th>Kontak WhatsApp</th>
                    <th>Email</th>
                    <th>Rentang Umur</th>
                    <th>Pekerjaan</th>
                    <th>Waktu Daftar</th>
                    <th style="text-align:center; min-width: 90px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($leads)): ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i data-lucide="inbox" style="width:28px;height:28px;"></i>
                                </div>
                                <h4 style="font-weight:700;color:var(--text-dark);margin-bottom:4px;">Belum ada data leads</h4>
                                <p style="font-size:0.85rem;margin:0;">Calon donatur yang mengunduh ebook akan otomatis tercatat di sini.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($leads as $i => $lead): ?>
                    <tr class="lead-row" id="leadRow-<?= $lead['id'] ?>">
                        <td style="text-align:center;color:var(--text-muted);font-weight:600;">
                            <?= $i + 1 ?>
                        </td>
                        <td>
                            <div class="lead-name-cell">
                                <div class="lead-avatar">
                                    <?= strtoupper(substr($lead['nama_lengkap'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="lead-name-text search-target"><?= esc($lead['nama_lengkap']) ?></div>
                                    <div style="font-size:0.75rem;color:var(--text-muted);">Pendaftar Ebook</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php 
                                $cleanPhone = preg_replace('/[^0-9]/', '', $lead['nomor_whatsapp']);
                                if (substr($cleanPhone, 0, 1) === '0') {
                                    $waLink = '62' . substr($cleanPhone, 1);
                                } elseif (substr($cleanPhone, 0, 2) === '62') {
                                    $waLink = $cleanPhone;
                                } else {
                                    $waLink = '62' . $cleanPhone;
                                }
                            ?>
                            <a href="https://wa.me/<?= $waLink ?>" target="_blank" class="whatsapp-link search-target" title="Hubungi via WhatsApp">
                                <i data-lucide="message-circle" style="width:14px;height:14px;"></i>
                                <span><?= esc($lead['nomor_whatsapp']) ?></span>
                            </a>
                        </td>
                        <td>
                            <span class="search-target" style="font-size:0.85rem;color:#4a3f3b;"><?= esc($lead['email']) ?></span>
                        </td>
                        <td>
                            <?php 
                                $umurVal = $lead['rentang_umur'] ?? $lead['tanggal_lahir'] ?? null;
                            ?>
                            <?php if(!empty($umurVal)): ?>
                                <span class="badge-date search-target">
                                    <i data-lucide="clock" style="width:13px;height:13px;color:var(--brand-600);"></i>
                                    <?= esc($umurVal) ?>
                                </span>
                            <?php else: ?>
                                <span style="color:#b5a59e;font-size:0.82rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($lead['status_pekerjaan'])): ?>
                                <span class="badge-job search-target">
                                    <i data-lucide="briefcase" style="width:12px;height:12px;"></i>
                                    <?= esc($lead['status_pekerjaan']) ?>
                                </span>
                            <?php else: ?>
                                <span style="color:#b5a59e;font-size:0.82rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="font-size:0.82rem;color:#4a3f3b;">
                                <?= date('d M Y, H:i', strtotime($lead['created_at'])) ?>
                            </div>
                            <?php if(!empty($lead['updated_at']) && strtotime($lead['updated_at']) > strtotime($lead['created_at'])): ?>
                                <div style="font-size:0.72rem;color:var(--brand-600);margin-top:2px;font-weight:600;" title="Terakhir interaksi: <?= date('d M Y, H:i', strtotime($lead['updated_at'])) ?>">
                                    Update: <?= date('d/m/y H:i', strtotime($lead['updated_at'])) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center;">
                            <button type="button" class="btn-act btn-act-delete" onclick="openDeleteLeadModal(<?= $lead['id'] ?>, '<?= esc($lead['nama_lengkap'], 'js') ?>', '<?= esc($lead['email'], 'js') ?>')" title="Hapus Data Lead">
                                <i data-lucide="trash-2" style="width:13px;height:13px;"></i>
                                <span>Hapus</span>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="table-footer-info">
        <div>
            Menampilkan <strong id="visibleCount"><?= count($leads) ?></strong> dari <strong id="totalLeadsCountText"><?= count($leads) ?></strong> total leads
        </div>
        <div>
            <span style="font-size:0.78rem;color:#8a7a75;">Data terupdate otomatis</span>
        </div>
    </div>
</div>

<!-- Secondary Table: Rekap Intensi Donasi -->
<div class="data-card" id="sectionDonations">
    <div class="data-card-header">
        <div class="data-card-title-wrap">
            <h2 class="data-card-title">
                <i data-lucide="heart-handshake" style="color:#d97706;width:20px;height:20px;"></i>
                Rekap Intensi Donasi
            </h2>
            <p class="data-card-subtitle">
                Daftar donatur yang telah memilih paket donasi untuk anak yatim melalui formulir.
            </p>
        </div>

        <div class="data-card-actions">
            <!-- Client Search Box -->
            <div class="table-search-box">
                <span class="search-icon-wrapper">
                    <i data-lucide="search"></i>
                </span>
                <input type="text" id="donationSearch" class="table-search-input" placeholder="Cari nama, metode, nominal..." oninput="filterDonations()">
            </div>

            <!-- Export to Excel Button for Donations -->
            <a href="<?= site_url('admin/export-donations') ?>" class="btn-export-excel btn-export-amber" id="btnExportDonations" title="Download rekap donasi dalam format Excel (.xls)">
                <i data-lucide="file-spreadsheet"></i>
                <span>Export Excel Donasi (.xls)</span>
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="modern-table" id="donationsTable">
            <thead>
                <tr>
                    <th style="width: 45px; text-align:center;">#</th>
                    <th>Nama Donatur</th>
                    <th>Kontak WhatsApp</th>
                    <th>Nominal Donasi</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th>Waktu Donasi</th>
                    <th style="text-align:center; min-width: 175px;">Aksi Validasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($donations)): ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon" style="background:#fef3c7;color:#d97706;">
                                    <i data-lucide="heart" style="width:28px;height:28px;"></i>
                                </div>
                                <h4 style="font-weight:700;color:var(--text-dark);margin-bottom:4px;">Belum ada data donasi</h4>
                                <p style="font-size:0.85rem;margin:0;">Setiap donatur yang memilih paket donasi akan otomatis masuk ke tabel ini.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($donations as $i => $don): ?>
                    <tr class="donation-row" id="donationRow-<?= $don['id'] ?>">
                        <td style="text-align:center;color:var(--text-muted);font-weight:600;">
                            <?= $i + 1 ?>
                        </td>
                        <td>
                            <div class="lead-name-cell">
                                <div class="lead-avatar" style="background:linear-gradient(135deg, #fef3c7, #fde68a);color:#92400e;">
                                    <?= strtoupper(substr($don['nama_lengkap'] ?? 'D', 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="lead-name-text search-target-don"><?= esc($don['nama_lengkap'] ?? 'Anonim') ?></div>
                                    <div style="font-size:0.75rem;color:var(--text-muted);"><?= esc($don['email'] ?? '-') ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if(!empty($don['nomor_whatsapp'])): ?>
                                <?php 
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $don['nomor_whatsapp']);
                                    if (substr($cleanPhone, 0, 1) === '0') {
                                        $waLink = '62' . substr($cleanPhone, 1);
                                    } elseif (substr($cleanPhone, 0, 2) === '62') {
                                        $waLink = $cleanPhone;
                                    } else {
                                        $waLink = '62' . $cleanPhone;
                                    }
                                    $waMsg = "Halo kak " . ($don['nama_lengkap'] ?? '') . ", kami dari Komunitas Waris Planning Indonesia (Kowpi). Kami mengonfirmasi niat donasi fikih harta anak yatim sebesar Rp " . number_format($don['amount'], 0, ',', '.') . " via " . ($don['payment_method'] ?? 'Transfer') . ". Apakah sudah berhasil melakukan transfer?";
                                ?>
                                <a href="https://wa.me/<?= $waLink ?>?text=<?= rawurlencode($waMsg) ?>" target="_blank" class="whatsapp-link search-target-don" title="Hubungi & konfirmasi via WhatsApp">
                                    <i data-lucide="message-circle" style="width:14px;height:14px;"></i>
                                    <span><?= esc($don['nomor_whatsapp']) ?></span>
                                </a>
                            <?php else: ?>
                                <span style="color:#b5a59e;font-size:0.82rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong class="search-target-don" style="color:#059669;font-size:0.95rem;">
                                Rp <?= number_format($don['amount'], 0, ',', '.') ?>
                            </strong>
                        </td>
                        <td>
                            <span class="badge-job search-target-don" style="background:#fef3c7;color:#92400e;border-color:#fde68a;">
                                <i data-lucide="credit-card" style="width:12px;height:12px;"></i>
                                <?= esc(strtoupper($don['payment_method'])) ?>
                            </span>
                        </td>
                        <td id="donationStatusCol-<?= $don['id'] ?>">
                            <?php $currStatus = $don['status'] ?? 'pending'; ?>
                            <?php if($currStatus === 'success'): ?>
                                <span class="badge-status-success search-target-don">
                                    <i data-lucide="check-circle-2" style="width:12px;height:12px;"></i>
                                    Berhasil
                                </span>
                            <?php elseif($currStatus === 'cancelled'): ?>
                                <span class="badge-status-cancelled search-target-don">
                                    <i data-lucide="x-circle" style="width:12px;height:12px;"></i>
                                    Dibatalkan
                                </span>
                            <?php else: ?>
                                <span class="badge-status-pending search-target-don">
                                    <i data-lucide="clock" style="width:12px;height:12px;"></i>
                                    Menunggu
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="font-size:0.82rem;color:#4a3f3b;">
                                <?= date('d M Y, H:i', strtotime($don['created_at'])) ?>
                            </div>
                        </td>
                        <td style="text-align:center;">
                            <div class="btn-action-group" id="donationActions-<?= $don['id'] ?>">
                                <?php if($currStatus === 'success'): ?>
                                    <button type="button" class="btn-act btn-act-pending" onclick="updateDonationStatus(<?= $don['id'] ?>, 'pending', '<?= esc($don['nama_lengkap'] ?? 'Donatur', 'js') ?>')" title="Ubah status kembali ke Menunggu">
                                        <i data-lucide="rotate-ccw" style="width:13px;height:13px;"></i>
                                        <span>Batal Validasi</span>
                                    </button>
                                <?php elseif($currStatus === 'cancelled'): ?>
                                    <button type="button" class="btn-act btn-act-pending" onclick="updateDonationStatus(<?= $don['id'] ?>, 'pending', '<?= esc($don['nama_lengkap'] ?? 'Donatur', 'js') ?>')" title="Pulihkan ke status Menunggu">
                                        <i data-lucide="rotate-ccw" style="width:13px;height:13px;"></i>
                                        <span>Pulihkan</span>
                                    </button>
                                    <button type="button" class="btn-act btn-act-success" onclick="updateDonationStatus(<?= $don['id'] ?>, 'success', '<?= esc($don['nama_lengkap'] ?? 'Donatur', 'js') ?>')" title="Verifikasi Pembayaran Diterima">
                                        <i data-lucide="check-circle" style="width:13px;height:13px;"></i>
                                        <span>Validasi</span>
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn-act btn-act-success" onclick="updateDonationStatus(<?= $don['id'] ?>, 'success', '<?= esc($don['nama_lengkap'] ?? 'Donatur', 'js') ?>')" title="Tandai pembayaran telah diterima di rekening">
                                        <i data-lucide="check-circle" style="width:13px;height:13px;"></i>
                                        <span>Validasi Berhasil</span>
                                    </button>
                                    <button type="button" class="btn-act btn-act-cancel" onclick="updateDonationStatus(<?= $don['id'] ?>, 'cancelled', '<?= esc($don['nama_lengkap'] ?? 'Donatur', 'js') ?>')" title="Tandai donasi dibatalkan / tidak jadi">
                                        <i data-lucide="x" style="width:13px;height:13px;"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="table-footer-info">
        <div>
            Menampilkan <strong id="visibleDonationsCount"><?= count($donations) ?></strong> dari <strong><?= count($donations) ?></strong> total donasi
        </div>
        <div>
            <span style="font-size:0.78rem;color:#8a7a75;">Data terupdate otomatis</span>
        </div>
    </div>
</div>

<script>
    // Live Search Filter for Leads Table
    function filterLeads() {
        const query = document.getElementById('leadSearch').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.lead-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const targets = row.querySelectorAll('.search-target');
            let matched = false;

            targets.forEach(el => {
                if (el.textContent.toLowerCase().includes(query)) {
                    matched = true;
                }
            });

            if (matched || query === '') {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const countEl = document.getElementById('visibleCount');
        if (countEl) {
            countEl.textContent = visibleCount;
        }
    }

    // Live Search Filter for Donations Table
    function filterDonations() {
        const query = document.getElementById('donationSearch').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.donation-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const targets = row.querySelectorAll('.search-target-don');
            let matched = false;

            targets.forEach(el => {
                if (el.textContent.toLowerCase().includes(query)) {
                    matched = true;
                }
            });

            if (matched || query === '') {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const countEl = document.getElementById('visibleDonationsCount');
        if (countEl) {
            countEl.textContent = visibleCount;
        }
    }

    // Handle Ebook File Selected Preview
    function handleEbookFileSelect(input) {
        const badge = document.getElementById('selectedFileBadge');
        const nameSpan = document.getElementById('selectedFileName');
        const title = document.getElementById('dropZoneTitle');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
            nameSpan.textContent = file.name + ' (' + sizeMb + ' MB)';
            badge.classList.remove('hidden');
            title.textContent = 'File PDF siap diunggah:';
        } else {
            badge.classList.add('hidden');
            title.textContent = 'Klik atau seret file PDF baru ke sini';
        }
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    // Modal Popup Preview Functions
    function openPdfModal() {
        const modal = document.getElementById('pdfModal');
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            if (window.lucide) {
                lucide.createIcons();
            }
        }
    }

    function closePdfModal() {
        const modal = document.getElementById('pdfModal');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    function handlePdfModalBackdropClick(e) {
        if (e.target && e.target.id === 'pdfModal') {
            closePdfModal();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePdfModal();
            closeDeleteLeadModal();
        }
    });

    // Handle Ebook Form Submit Validation & Loading State
    function handleEbookFormSubmit(e) {
        const input = document.getElementById('ebookFile');
        if (!input.files || input.files.length === 0) {
            e.preventDefault();
            alert('Silakan pilih file PDF terlebih dahulu sebelum mengklik tombol Upload!');
            return false;
        }
        const file = input.files[0];
        const fileName = file.name.toLowerCase();
        if (!fileName.endsWith('.pdf') && file.type !== 'application/pdf') {
            e.preventDefault();
            alert('Format file tidak didukung. Mohon pilih file berformat PDF (.pdf)!');
            return false;
        }
        if (file.size > 30 * 1024 * 1024) {
            e.preventDefault();
            alert('Ukuran file melebihi batas maksimal 30 MB!');
            return false;
        }

        const btn = document.getElementById('btnSubmitEbook');
        const btnText = document.getElementById('btnSubmitText');
        btn.disabled = true;
        btn.style.opacity = '0.8';
        btn.style.cursor = 'wait';
        btn.innerHTML = '<i data-lucide="loader-2" class="spin-icon" style="width:18px;height:18px;"></i> <span>Mengunggah & Memproses File...</span>';
        if (window.lucide) {
            lucide.createIcons();
        }
        return true;
    }

    // Drag and drop events visual cues
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZoneContainer');
        const fileInput = document.getElementById('ebookFile');
        if (dropZone && fileInput) {
            ['dragenter', 'dragover'].forEach(eventName => {
                fileInput.addEventListener(eventName, () => {
                    dropZone.classList.add('drag-active');
                }, false);
            });
            ['dragleave', 'drop'].forEach(eventName => {
                fileInput.addEventListener(eventName, () => {
                    dropZone.classList.remove('drag-active');
                }, false);
            });
        }
    });

    // AJAX Update Donation Status Handler
    function updateDonationStatus(id, newStatus, donorName) {
        const actionsContainer = document.getElementById('donationActions-' + id);
        const statusCol = document.getElementById('donationStatusCol-' + id);
        if (!actionsContainer) return;

        const originalButtonsHtml = actionsContainer.innerHTML;
        actionsContainer.innerHTML = `
            <span style="font-size:0.75rem;color:#8a7a75;display:inline-flex;align-items:center;gap:5px;">
                <svg style="width:13px;height:13px;animation:spin 1s linear infinite;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle>
                    <path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"></path>
                </svg>
                Menyimpan...
            </span>
        `;

        const formData = new FormData();
        formData.append('id', id);
        formData.append('status', newStatus);

        fetch('<?= site_url('admin/update-donation-status') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // 1. Update status badge
                if (statusCol) {
                    if (newStatus === 'success') {
                        statusCol.innerHTML = `
                            <span class="badge-status-success search-target-don">
                                <i data-lucide="check-circle-2" style="width:12px;height:12px;"></i>
                                Berhasil
                            </span>
                        `;
                    } else if (newStatus === 'cancelled') {
                        statusCol.innerHTML = `
                            <span class="badge-status-cancelled search-target-don">
                                <i data-lucide="x-circle" style="width:12px;height:12px;"></i>
                                Dibatalkan
                            </span>
                        `;
                    } else {
                        statusCol.innerHTML = `
                            <span class="badge-status-pending search-target-don">
                                <i data-lucide="clock" style="width:12px;height:12px;"></i>
                                Menunggu
                            </span>
                        `;
                    }
                }

                // 2. Update action buttons
                if (newStatus === 'success') {
                    actionsContainer.innerHTML = `
                        <button type="button" class="btn-act btn-act-pending" onclick="updateDonationStatus(${id}, 'pending', '${donorName}')" title="Ubah status kembali ke Menunggu">
                            <i data-lucide="rotate-ccw" style="width:13px;height:13px;"></i>
                            <span>Batal Validasi</span>
                        </button>
                    `;
                } else if (newStatus === 'cancelled') {
                    actionsContainer.innerHTML = `
                        <button type="button" class="btn-act btn-act-pending" onclick="updateDonationStatus(${id}, 'pending', '${donorName}')" title="Pulihkan ke status Menunggu">
                            <i data-lucide="rotate-ccw" style="width:13px;height:13px;"></i>
                            <span>Pulihkan</span>
                        </button>
                        <button type="button" class="btn-act btn-act-success" onclick="updateDonationStatus(${id}, 'success', '${donorName}')" title="Verifikasi Pembayaran Diterima">
                            <i data-lucide="check-circle" style="width:13px;height:13px;"></i>
                            <span>Validasi</span>
                        </button>
                    `;
                } else {
                    actionsContainer.innerHTML = `
                        <button type="button" class="btn-act btn-act-success" onclick="updateDonationStatus(${id}, 'success', '${donorName}')" title="Tandai pembayaran telah diterima di rekening">
                            <i data-lucide="check-circle" style="width:13px;height:13px;"></i>
                            <span>Validasi Berhasil</span>
                        </button>
                        <button type="button" class="btn-act btn-act-cancel" onclick="updateDonationStatus(${id}, 'cancelled', '${donorName}')" title="Tandai donasi dibatalkan / tidak jadi">
                            <i data-lucide="x" style="width:13px;height:13px;"></i>
                        </button>
                    `;
                }

                // 3. Update stat card metrics
                if (data.stats) {
                    const successCountEl = document.getElementById('statDonationSuccessCount');
                    const successValEl = document.getElementById('statDonationSuccessVal');
                    const pendingCountEl = document.getElementById('statDonationPendingCount');
                    if (successCountEl) successCountEl.textContent = data.stats.count_success;
                    if (successValEl) successValEl.textContent = data.stats.total_success_fmt;
                    if (pendingCountEl) pendingCountEl.textContent = data.stats.count_pending;
                }

                if (window.lucide) {
                    lucide.createIcons();
                }

                showAdminToast(data.message || `Status donasi ${donorName} berhasil diperbarui!`, 'success');
            } else {
                actionsContainer.innerHTML = originalButtonsHtml;
                if (window.lucide) lucide.createIcons();
                showAdminToast(data.message || 'Gagal mengubah status donasi.', 'danger');
            }
        })
        .catch(err => {
            console.error(err);
            actionsContainer.innerHTML = originalButtonsHtml;
            if (window.lucide) lucide.createIcons();
            showAdminToast('Terjadi kesalahan koneksi.', 'danger');
        });
    }

    // Dynamic floating toast notification
    function showAdminToast(msg, type = 'success') {
        let container = document.getElementById('adminToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'adminToastContainer';
            container.className = 'admin-toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `admin-toast admin-toast-${type}`;
        const iconSvg = type === 'success' 
            ? `<svg style="width:18px;height:18px;color:#10b981;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`
            : `<svg style="width:18px;height:18px;color:#ef4444;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;

        toast.innerHTML = `${iconSvg} <span>${msg}</span>`;
        container.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.add('show');
        });

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    // ============================================
    // Delete Lead Handlers (Modal & AJAX)
    // ============================================
    let pendingDeleteLeadId = null;

    function openDeleteLeadModal(id, name, email) {
        pendingDeleteLeadId = id;
        const modal = document.getElementById('deleteLeadModal');
        const nameEl = document.getElementById('deleteTargetName');
        const emailEl = document.getElementById('deleteTargetEmail');
        const avatarEl = document.getElementById('deleteTargetAvatar');

        if (nameEl) nameEl.textContent = name || 'Pendaftar';
        if (emailEl) emailEl.textContent = email || '-';
        if (avatarEl) avatarEl.textContent = (name || 'P').trim().charAt(0).toUpperCase();

        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            if (window.lucide) lucide.createIcons();
        }
    }

    function closeDeleteLeadModal() {
        const modal = document.getElementById('deleteLeadModal');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
        pendingDeleteLeadId = null;

        const btn = document.getElementById('btnConfirmDeleteLead');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i data-lucide="trash-2" style="width:15px;height:15px;"></i> <span>Ya, Hapus Data</span>';
            if (window.lucide) lucide.createIcons();
        }
    }

    function handleDeleteModalBackdropClick(e) {
        if (e.target && e.target.id === 'deleteLeadModal') {
            closeDeleteLeadModal();
        }
    }

    function confirmDeleteLeadSubmit() {
        if (!pendingDeleteLeadId) return;

        const id = pendingDeleteLeadId;
        const btn = document.getElementById('btnConfirmDeleteLead');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<svg style="width:15px;height:15px;animation:spin 1s linear infinite;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle><path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"></path></svg> <span>Menghapus...</span>';
        }

        const formData = new FormData();
        formData.append('id', id);

        fetch('<?= site_url('admin/delete-lead') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            closeDeleteLeadModal();

            if (data.success) {
                // 1. Animate row removal
                const row = document.getElementById('leadRow-' + id);
                if (row) {
                    row.style.transition = 'all 0.35s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(20px)';
                    row.style.backgroundColor = '#fef2f2';
                    setTimeout(() => {
                        row.remove();
                        // Re-number remaining rows
                        const rows = document.querySelectorAll('#leadsTable tbody .lead-row');
                        rows.forEach((r, idx) => {
                            const numCell = r.querySelector('td:first-child');
                            if (numCell) numCell.textContent = idx + 1;
                        });

                        // If empty, show empty state
                        if (rows.length === 0) {
                            const tbody = document.querySelector('#leadsTable tbody');
                            if (tbody) {
                                tbody.innerHTML = `
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                <div class="empty-state-icon">
                                                    <i data-lucide="inbox" style="width:28px;height:28px;"></i>
                                                </div>
                                                <h4 style="font-weight:700;color:var(--text-dark);margin-bottom:4px;">Belum ada data leads</h4>
                                                <p style="font-size:0.85rem;margin:0;">Calon donatur yang mengunduh ebook akan otomatis tercatat di sini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                                if (window.lucide) lucide.createIcons();
                            }
                        }

                        // Re-trigger filter count
                        filterLeads();
                    }, 350);
                }

                // 2. Update stat cards and totals
                if (data.stats) {
                    const totalLeadsEl = document.getElementById('statTotalLeads');
                    const leadsTodayEl = document.getElementById('statLeadsToday');
                    const totalCountEl = document.getElementById('totalLeadsCountText');
                    if (totalLeadsEl) totalLeadsEl.textContent = data.stats.total_leads_fmt;
                    if (leadsTodayEl) leadsTodayEl.textContent = data.stats.leads_today_fmt;
                    if (totalCountEl) totalCountEl.textContent = data.stats.total_leads;

                    // If any related donations were removed, sync donation stats as well
                    const donTotalEl = document.getElementById('statDonationTotal');
                    const donSuccessValEl = document.getElementById('statDonationSuccessVal');
                    const donSuccessCountEl = document.getElementById('statDonationSuccessCount');
                    const donPendingCountEl = document.getElementById('statDonationPendingCount');
                    if (donTotalEl) donTotalEl.textContent = 'Rp ' + data.stats.total_donations_fmt;
                    if (donSuccessValEl) donSuccessValEl.textContent = data.stats.total_donations_success_fmt;
                    if (donSuccessCountEl) donSuccessCountEl.textContent = data.stats.count_donations_success;
                    if (donPendingCountEl) donPendingCountEl.textContent = data.stats.count_donations_pending;
                }

                showAdminToast(data.message || 'Data lead berhasil dihapus!', 'success');
            } else {
                showAdminToast(data.message || 'Gagal menghapus data lead.', 'danger');
            }
        })
        .catch(err => {
            console.error(err);
            closeDeleteLeadModal();
            showAdminToast('Terjadi kesalahan koneksi saat menghapus data.', 'danger');
        });
    }
</script>
<?= $this->endSection() ?>
