<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =========================================================================
// 1. HOMEPAGE PUBLIK & PRESENSI MANDIRI (BEBAS AKSES TANPA LOGIN)
// =========================================================================
$routes->get('/', 'Home::index');
$routes->get('presensi', 'Home::index');
$routes->get('presensi/(:segment)', 'AttendanceController::kiosk/$1');
$routes->post('presensi/submit', 'AttendanceController::submitAttendance');

// Detail Rapat Publik & Pratinjau Dokumen Notula
$routes->get('notula/public-view/(:num)', 'Home::publicMeetingDetail/$1');
$routes->get('export/print-dokumen/(:num)', 'ExportController::printView/$1');

// =========================================================================
// 2. AUTENTIKASI PENGURUS & NOTULIS
// =========================================================================
$routes->get('login', 'AuthController::login');
$routes->post('login/submit', 'AuthController::submitLogin');
$routes->get('logout', 'AuthController::logout');

// =========================================================================
// 3. AREA PANEL ADMINISTRASI & NOTULENSI (WAJIB LOGIN)
// =========================================================================
$routes->group('', ['filter' => 'adminAuth'], function ($routes) {
    // Dashboard Utama
    $routes->get('dashboard', 'DashboardController::index');

    // Manajemen Rapat (CRUD)
    $routes->get('rapat', 'MeetingController::index');
    $routes->get('rapat/create', 'MeetingController::create');
    $routes->post('rapat/store', 'MeetingController::store');
    $routes->get('rapat/detail/(:num)', 'MeetingController::detail/$1');
    $routes->get('rapat/edit/(:num)', 'MeetingController::edit/$1');
    $routes->post('rapat/update/(:num)', 'MeetingController::update/$1');
    $routes->get('rapat/delete/(:num)', 'MeetingController::delete/$1');
    $routes->post('rapat/toggle-presence/(:num)', 'MeetingController::togglePresence/$1');
    $routes->post('rapat/change-status/(:num)', 'MeetingController::changeStatus/$1');

    // Manajemen Daftar Kehadiran Per Rapat
    $routes->get('rapat/(:num)/kehadiran', 'AttendanceController::manage/$1');
    $routes->post('rapat/(:num)/kehadiran/add', 'AttendanceController::adminAdd/$1');
    $routes->get('kehadiran/delete/(:num)', 'AttendanceController::delete/$1');
    $routes->get('kehadiran/export-excel/(:num)', 'AttendanceController::exportExcel/$1');

    // Manajemen Notula Rapat
    $routes->get('rapat/(:num)/notula', 'NotulaController::edit/$1');
    $routes->post('rapat/(:num)/notula/save', 'NotulaController::save/$1');
    $routes->post('rapat/(:num)/notula/sign', 'NotulaController::saveSignature/$1');
    $routes->get('rapat/(:num)/notula/view', 'NotulaController::view/$1');

    // Manajemen Dokumentasi Foto Rapat
    $routes->get('rapat/(:num)/dokumentasi', 'DocumentationController::index/$1');
    $routes->post('rapat/(:num)/dokumentasi/upload', 'DocumentationController::upload/$1');
    $routes->post('dokumentasi/update-caption/(:num)', 'DocumentationController::updateCaption/$1');
    $routes->get('dokumentasi/delete/(:num)', 'DocumentationController::delete/$1');

    // Direktori Arsip
    $routes->get('arsip', 'ArchiveController::index');
    $routes->post('arsip/archive/(:num)', 'ArchiveController::archiveMeeting/$1');
    $routes->post('arsip/unarchive/(:num)', 'ArchiveController::unarchiveMeeting/$1');
    $routes->get('arsip/bundle/(:num)', 'ArchiveController::bundleView/$1');

    // Cetak & Ekspor Dokumen
    $routes->get('export/print-dokumen/(:num)', 'ExportController::printView/$1');
    $routes->get('export/notula-pdf/(:num)', 'ExportController::notulaPdf/$1');
    $routes->get('export/kehadiran-pdf/(:num)', 'ExportController::attendancePdf/$1');
    $routes->get('export/berkas-lengkap-pdf/(:num)', 'ExportController::completeMeetingPdf/$1');

    // Pengaturan
    $routes->get('pengaturan', 'SettingsController::index');
    $routes->post('pengaturan/update', 'SettingsController::update');
});
