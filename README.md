# Digital Meeting Minutes, Stylus Attendance & Official Archive System (CI4)

> **End-to-End Organizational Meeting Governance Platform**  
> *Agenda Management, Tablet/Stylus Digital Signatures, Action Item Tracking, Photo Gallery & Locked PDF Archives*

[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![CodeIgniter 4](https://img.shields.io/badge/CodeIgniter-4.x_MVC-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)](https://codeigniter.com/)
[![MySQL](https://img.shields.io/badge/MySQL-Relational-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Portfolio](https://img.shields.io/badge/Full_Portfolio-15_Systems-0284c7?style=for-the-badge)](https://prestianhanif.github.io/portfolio/portfolio.html)

---

## Overview

Developed for **Komunitas Waris Planning Indonesia (KOWPI)**, this CodeIgniter 4 web platform digitizes the complete lifecycle of formal organizational meetings — from agenda setup and kiosk-mode digital check-in to structured minutes, official digital ratification, photo documentation, and tamper-resistant historical archiving.

---

## Key Features

- **Self-Service Digital Attendance Kiosk (`AttendanceController`):** Responsive HTML5 Canvas signature pad supporting stylus, iPad/tablet touchscreens, and mouse input across *Offline*, *Online*, *Excused*, and *Sick* statuses.
- **Live Meeting Room Attendance Board:** Auto-polling display screen with live clock and participant check-in feed every 4 seconds.
- **Structured Meeting Minutes & Action Items (`NotulaController`):** Captures opening remarks, discussions, binding resolutions, dynamic Action Items table (Task, PIC, Deadline, Status), plus dual digital signatures (Meeting Chair & Secretary) and transparent official stamp overlay.
- **Photo Documentation Gallery (`DocumentationController`):** Multi-file upload (JPG/PNG/WEBP) with captions, interactive lightbox preview, and automatic inclusion in exported PDF bundles.
- **Locked Official Archive Directory (`ArchiveController`):** Searchable archive filtered by year, month, and category with one-click lock (`LOCKED & VALID`) to safeguard finalized records.
- **Official PDF & Excel Reporting (`PdfController`, `ExportController`):** Formal institutional letterhead formatting ready for A4 print and spreadsheet export.

---

## Tech Stack

- **Backend:** PHP 8.x, CodeIgniter 4 MVC
- **Database:** MySQL / MariaDB (`database/schema.sql` — 6 normalized tables with foreign key constraints)
- **Frontend:** HTML5 Canvas API, Responsive CSS (`@media print` A4 calibration), Vanilla JavaScript
- **Reporting:** mPDF / PDF Generator & Excel Export

---

## Quick Local Setup

```bash
# 1. Clone repository & install dependencies
git clone https://github.com/PrestianHanif/ci4-meeting-minutes-attendance.git
cd ci4-meeting-minutes-attendance
composer install

# 2. Configure environment
cp .env.example .env
# Update database & app.baseURL in .env

# 3. Import database schema
mysql -u root -p db_meeting_minutes < database/schema.sql

# 4. Run development server
php spark serve
```

---

## Author

**Prestyan Dwi Febrianto** — Fullstack Web Developer & Operations Specialist  
- Portfolio: [prestianhanif.github.io/portfolio/portfolio.html](https://prestianhanif.github.io/portfolio/portfolio.html)  
- Interactive CV: [prestianhanif.github.io/portfolio/cv.html](https://prestianhanif.github.io/portfolio/cv.html)  
- LinkedIn: [linkedin.com/in/prestyan-dwi-febrianto-6a5bb2406](https://linkedin.com/in/prestyan-dwi-febrianto-6a5bb2406)
