-- Database Schema untuk Sistem Aplikasi Notula & Daftar Hadir Rapat KOWPI
-- Target: http://localhost/app-notula-kowpi/
-- Tanggal: 29 Oktober 2026

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

-- -------------------------------------------------------------
-- 1. Tabel `admins`
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('admin','notulis','pimpinan') NOT NULL DEFAULT 'admin',
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin Default: username = admin | password = admin123
INSERT INTO `admins` (`id`, `username`, `password_hash`, `full_name`, `role`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$7R4465gD9h7NqWqVfU3aNuBhyjV0ZqjH6y3e5ZgN2G9.7w9Q1K30C', 'Administrator Sekretariat KOWPI', 'admin', 'sekretariat@kowpi.id', '081225800000', NOW(), NOW()),
(2, 'notulis', '$2y$10$7R4465gD9h7NqWqVfU3aNuBhyjV0ZqjH6y3e5ZgN2G9.7w9Q1K30C', 'Notulis Tim Kerja KOWPI', 'notulis', 'notulis@kowpi.id', '081225800001', NOW(), NOW());

-- -------------------------------------------------------------
-- 2. Tabel `settings`
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_name` varchar(255) NOT NULL DEFAULT 'Komunitas Waris Planning Indonesia (KOWPI)',
  `org_short` varchar(50) NOT NULL DEFAULT 'KOWPI',
  `org_tagline` varchar(255) DEFAULT 'Edukasi, Literasi & Pendampingan Perencanaan Waris Sesuai Syariat Islam',
  `org_address` text DEFAULT 'Gedung KOWPI Center / Kampus Terpadu UII, Jl. Kaliurang KM. 14,5 Sleman, D.I. Yogyakarta 55584',
  `org_website` varchar(100) DEFAULT 'https://kowpi.id',
  `org_email` varchar(100) DEFAULT 'sekretariat@kowpi.id',
  `org_phone` varchar(50) DEFAULT '0812-2580-0000',
  `org_logo` varchar(255) DEFAULT 'assets/img/logo-kowpi-coklat.png',
  `org_stamp` varchar(255) DEFAULT 'assets/img/stempel-kowpi-transparan.png',
  `default_pimpinan` varchar(150) DEFAULT 'Dr. Drs. Asmuni, M.A.',
  `default_pimpinan_title` varchar(100) DEFAULT 'Ketua Dewan Pembina KOWPI',
  `default_notulis` varchar(150) DEFAULT 'Ust. Muhammad Abu Rivai, S.H.I., M.H.',
  `default_notulis_title` varchar(100) DEFAULT 'Sekretaris Eksekutif KOWPI',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`id`, `org_name`, `org_short`, `org_tagline`, `org_address`, `org_website`, `org_email`, `org_phone`, `org_logo`, `org_stamp`, `default_pimpinan`, `default_pimpinan_title`, `default_notulis`, `default_notulis_title`) VALUES
(1, 'Komunitas Waris Planning Indonesia (KOWPI)', 'KOWPI', 'Edukasi, Literasi & Pendampingan Perencanaan Waris Sesuai Syariat Islam', 'Gedung KOWPI Center / Kampus Terpadu UII, Jl. Kaliurang KM. 14,5 Sleman, D.I. Yogyakarta 55584', 'https://kowpi.id', 'sekretariat@kowpi.id', '0812-2580-0000', 'assets/img/logo-kowpi-coklat.png', 'assets/img/stempel-kowpi-transparan.png', 'Dr. Drs. Asmuni, M.A.', 'Ketua Dewan Pembina KOWPI', 'Ust. Muhammad Abu Rivai, S.H.I., M.H.', 'Sekretaris Eksekutif KOWPI');

-- -------------------------------------------------------------
-- 3. Tabel `meetings`
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `meetings`;
CREATE TABLE `meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_code` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(80) NOT NULL DEFAULT 'Rapat Koordinasi',
  `meeting_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `meeting_type` enum('offline','online','hybrid') NOT NULL DEFAULT 'offline',
  `location` varchar(255) DEFAULT 'Ruang Rapat Utama Gedung KOWPI Center',
  `meeting_link` varchar(255) DEFAULT NULL,
  `leader_name` varchar(150) NOT NULL,
  `leader_title` varchar(100) DEFAULT 'Pimpinan Rapat',
  `notary_name` varchar(150) NOT NULL,
  `agenda` text NOT NULL,
  `status` enum('draft','ongoing','completed','archived') NOT NULL DEFAULT 'ongoing',
  `is_presence_open` tinyint(1) NOT NULL DEFAULT 1,
  `archived_at` datetime DEFAULT NULL,
  `archived_by` varchar(100) DEFAULT NULL,
  `archive_notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `meeting_code` (`meeting_code`),
  KEY `idx_status` (`status`),
  KEY `idx_date` (`meeting_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 4. Tabel `attendances`
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `attendances`;
CREATE TABLE `attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` int(10) unsigned NOT NULL,
  `participant_name` varchar(200) NOT NULL,
  `institution` varchar(150) DEFAULT 'Pengurus KOWPI',
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `attendance_status` enum('hadir_offline','hadir_online','izin','sakit') NOT NULL DEFAULT 'hadir_offline',
  `check_in_time` datetime NOT NULL,
  `signature_image` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_att_meeting` (`meeting_id`),
  KEY `idx_att_status` (`attendance_status`),
  CONSTRAINT `fk_att_meeting` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 5. Tabel `meeting_minutes`
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `meeting_minutes`;
CREATE TABLE `meeting_minutes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` int(10) unsigned NOT NULL,
  `opening_notes` text DEFAULT NULL,
  `discussion` longtext DEFAULT NULL,
  `decisions` longtext DEFAULT NULL,
  `action_items` longtext DEFAULT NULL,
  `closing_notes` text DEFAULT NULL,
  `leader_signature` varchar(255) DEFAULT NULL,
  `notary_signature` varchar(255) DEFAULT NULL,
  `is_signed_leader` tinyint(1) DEFAULT 0,
  `is_signed_notary` tinyint(1) DEFAULT 0,
  `include_stamp` tinyint(1) DEFAULT 1,
  `pdf_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_minutes_meeting` (`meeting_id`),
  CONSTRAINT `fk_minutes_meeting` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 6. Tabel `meeting_documentations`
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `meeting_documentations`;
CREATE TABLE `meeting_documentations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` int(10) unsigned NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `taken_at` datetime DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_doc_meeting` (`meeting_id`),
  CONSTRAINT `fk_doc_meeting` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Sample Initial Data (Rapat Perdana KOWPI)
-- -------------------------------------------------------------
INSERT INTO `meetings` (`id`, `meeting_code`, `title`, `category`, `meeting_date`, `start_time`, `end_time`, `meeting_type`, `location`, `meeting_link`, `leader_name`, `leader_title`, `notary_name`, `agenda`, `status`, `is_presence_open`, `created_at`) VALUES
(1, 'KOWPI-RPT-202610-001', 'Rapat Koordinasi Pleno Pengurus & Evaluasi Program Literasi Waris KOWPI Q4', 'Rapat Pleno', CURDATE(), '09:00:00', '12:00:00', 'hybrid', 'Ruang Rapat Utama Gedung KOWPI Center Lt. 2 / Zoom Meeting', 'https://meet.kowpi.id/pleno-q4', 'Dr. Drs. Asmuni, M.A.', 'Ketua Dewan Pembina KOWPI', 'Ust. Muhammad Abu Rivai, S.H.I., M.H.', '1. Pembukaan dan Doa bersama\n2. Evaluasi pelaksanaan program sosialisasi waris syariah bulan Oktober 2026\n3. Pembahasan penyusunan panduan digital mitigasi sengketa waris keluarga muslim\n4. Rencana kerja sama edukasi waris dengan universitas dan ormas Islam\n5. Tindak lanjut publikasi buku fikih harta anak yatim', 'ongoing', 1, NOW());

INSERT INTO `meeting_minutes` (`meeting_id`, `opening_notes`, `discussion`, `decisions`, `action_items`, `closing_notes`, `is_signed_leader`, `is_signed_notary`, `include_stamp`) VALUES
(1, 
'Rapat dibuka tepat pukul 09.00 WIB oleh Pimpinan Rapat, Dr. Drs. Asmuni, M.A., dengan membaca Ummul Kitab Surat Al-Fatihah. Beliau menyampaikan pentingnya konsolidasi berkala pengurus KOWPI untuk memastikan literasi hukum waris Islam semakin membumi dan diterima oleh masyarakat luas tanpa menimbulkan friksi sengketa.',

'1. Evaluasi Program Bulan Oktober:\n- Webinar edukasi perencanaan waris telah menjangkau lebih dari 850 peserta dari berbagai kota di Indonesia.\n- Tingkat pemahaman awal masyarakat terhadap faraidh perlu diperkuat dengan studi kasus praktis dan kalkulator waris digital.\n\n2. Mitigasi Sengketa Waris:\n- Banyak keluarga muslim terlambat mengurus pembagian waris karena tabu membicarakan harta saat pewaris masih hidup.\n- KOWPI merekomendasikan pendekatan wasiat taqsim dan musyawarah keluarga (ishlah) sebelum sengketa masuk ke Pengadilan Agama.\n\n3. Rencana Penerbitan & Diseminasi Buku:\n- Hasil riset doktoral tentang mitigasi sengketa waris siap disosialisasikan dalam bentuk format ringkas buku saku dan PDF interaktif.',

'1. Menyetujui penerbitan Modul Praktis Panduan Waris Ramah Keluarga KOWPI versi 2.0 yang ditargetkan rilis pertengahan November 2026.\n2. Membuka layanan konsultasi waris online terstruktur melalui portal resmi kowpi.id setiap hari Sabtu & Ahad.\n3. Menjadwalkan rapat kerja teknis divisi kurikulum pada pekan kedua November 2026.\n4. Memvalidasi format digital notula dan daftar kehadiran resmi KOWPI sebagai standar administrasi organisasi.',

'[{"task":"Finalisasi naskah Modul Panduan Waris Ramah Keluarga","pic":"Ust. Abu Rivai & Tim Riset","deadline":"2026-11-10","status":"Dalam Proses"},{"task":"Pengembangan modul pendaftaran konsultasi online di kowpi.id","pic":"Divisi IT & Media KOWPI","deadline":"2026-11-05","status":"Dalam Proses"},{"task":"Distribusi notula dan dokumentasi rapat kepada seluruh anggota dewan","pic":"Sekretariat KOWPI","deadline":"2026-10-30","status":"Selesai"}]',

'Rapat diakhiri pada pukul 11.45 WIB dengan doa kafaratul majelis yang dipimpin oleh Pimpinan Rapat. Seluruh peserta menyepakati notula ini sebagai dokumen resmi keputusan bersama.',
1, 1, 1);

-- Sample Attendances
INSERT INTO `attendances` (`meeting_id`, `participant_name`, `institution`, `phone`, `email`, `attendance_status`, `check_in_time`, `notes`) VALUES
(1, 'Dr. Drs. Asmuni, M.A.', 'Dewan Pembina KOWPI / FIAI UII', '0811281001', 'asmuni@kowpi.id', 'hadir_offline', NOW() - INTERVAL 120 MINUTE, 'Hadir tepat waktu dan memimpin jalannya rapat.'),
(1, 'Ust. Muhammad Abu Rivai, S.H.I., M.H.', 'Sekretaris Eksekutif KOWPI', '081299887766', 'aburivai@kowpi.id', 'hadir_offline', NOW() - INTERVAL 115 MINUTE, 'Mencatat notula dan memfasilitasi materi pleno.'),
(1, 'Ir. H. Hendra Wijaya', 'Divisi Litbang & Kerjasama KOWPI', '081377665544', 'hendra@kowpi.id', 'hadir_offline', NOW() - INTERVAL 110 MINUTE, 'Siap mengawal kemitraan riset antar lembaga.'),
(1, 'Hj. Siti Rahmawati, S.E., M.M.', 'Bendahara KOWPI', '081544332211', 'rahma@kowpi.id', 'hadir_offline', NOW() - INTERVAL 105 MINUTE, 'Laporan anggaran program Q4 terlampir rapi.'),
(1, 'Ahmad Fauzi, S.Kom.', 'Koordinator IT & Digital Platform', '085712345678', 'fauzi@kowpi.id', 'hadir_offline', NOW() - INTERVAL 100 MINUTE, 'Sistem notula & presensi digital siap digunakan.');

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

