<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuestModel;
use App\Models\EventSettingsModel;
use App\Services\PdfGeneratorService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ZipArchive;

class GuestController extends BaseController
{
    protected GuestModel $guestModel;
    protected EventSettingsModel $settingsModel;

    public function __construct()
    {
        $this->guestModel = new GuestModel();
        $this->settingsModel = new EventSettingsModel();
    }

    public function index()
    {
        $search = $this->request->getGet('q');
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');
        $institution = $this->request->getGet('institution');

        $query = $this->guestModel->filterGuests($search, $status, $type, $institution);
        $guests = $query->orderBy('guest_type', 'ASC')
                        ->orderBy('id', 'ASC')
                        ->paginate(25);

        $pager = $this->guestModel->pager;
        $stats = $this->guestModel->getStats();
        $settings = $this->settingsModel->getSettings();
        $institutions = $this->guestModel->getInstitutionsList();

        // Hitung total tamu untuk lembaga yang sedang difilter
        $institutionCount = !empty($institution)
            ? $this->guestModel->where('institution', $institution)->countAllResults()
            : 0;

        $data = [
            'title'            => 'Manajemen Tamu Undangan — Sidang Promosi Doktor',
            'activeNav'        => 'guests',
            'guests'           => $guests,
            'pager'            => $pager,
            'stats'            => $stats,
            'settings'         => $settings,
            'search'           => $search,
            'status'           => $status,
            'type'             => $type,
            'institution'      => $institution,
            'institutions'     => $institutions,
            'institutionCount' => $institutionCount,
        ];

        return view('guests/index', $data);
    }

    public function store()
    {
        $salutation = trim($this->request->getPost('salutation') ?? 'Bapak/Ibu');
        $fullName = trim($this->request->getPost('full_name') ?? '');
        $institution = trim($this->request->getPost('institution') ?? '');
        $phone = trim($this->request->getPost('phone') ?? '');
        $guestType = $this->request->getPost('guest_type') === 'walk_in' ? 'walk_in' : 'invited';

        if (empty($fullName)) {
            return redirect()->back()->with('error', 'Nama lengkap tamu wajib diisi!');
        }

        $code = ($guestType === 'walk_in')
            ? $this->guestModel->getNextWalkInCode()
            : $this->guestModel->getNextInvitedCode();

        $slug = preg_replace('/[^A-Za-z0-9_]/', '_', $code);
        $pdfFilename = "Undangan_Promosi_Doktor_Muhammad_Abu_Rivai_{$slug}.pdf";

        $this->guestModel->insert([
            'guest_code'   => $code,
            'salutation'   => $salutation,
            'full_name'    => $fullName,
            'institution'  => $institution,
            'phone'        => $phone,
            'guest_type'   => $guestType,
            'pdf_filename' => $pdfFilename,
            'is_present'   => 0,
        ]);

        return redirect()->to('/tamu')->with('success', "Tamu [{$fullName}] berhasil ditambahkan dengan kode {$code}!");
    }

    public function update($id)
    {
        $guest = $this->guestModel->find($id);
        if (!$guest) {
            return redirect()->back()->with('error', 'Data tamu tidak ditemukan!');
        }

        $fullName = trim($this->request->getPost('full_name') ?? '');
        if (empty($fullName)) {
            return redirect()->back()->with('error', 'Nama lengkap tamu tidak boleh kosong!');
        }

        $this->guestModel->update($id, [
            'salutation'  => trim($this->request->getPost('salutation') ?? $guest['salutation']),
            'full_name'   => $fullName,
            'institution' => trim($this->request->getPost('institution') ?? ''),
            'phone'       => trim($this->request->getPost('phone') ?? ''),
        ]);

        return redirect()->to('/tamu')->with('success', "Data tamu [{$fullName}] berhasil diperbarui!");
    }

    public function delete($id)
    {
        $guest = $this->guestModel->find($id);
        if ($guest) {
            // Hapus file pdf jika ada
            if (!empty($guest['pdf_filename'])) {
                $pdfPath = FCPATH . 'uploads/pdf/' . $guest['pdf_filename'];
                if (file_exists($pdfPath)) {
                    @unlink($pdfPath);
                }
            }
            // Hapus file signature jika ada
            if (!empty($guest['signature_image'])) {
                $sigPath = FCPATH . $guest['signature_image'];
                if (file_exists($sigPath)) {
                    @unlink($sigPath);
                }
            }
            $this->guestModel->delete($id);
            return redirect()->to('/tamu')->with('success', "Data tamu [{$guest['full_name']}] berhasil dihapus!");
        }

        return redirect()->back()->with('error', 'Data tamu tidak ditemukan.');
    }

    /**
     * Import tamu dari CSV atau Excel (XLSX/XLS)
     */
    public function import()
    {
        $file = $this->request->getFile('file_excel');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Silakan pilih file CSV atau Excel yang valid!');
        }

        $ext = strtolower($file->getClientExtension());
        $tempPath = $file->getTempName();

        $rows = [];

        try {
            if ($ext === 'csv') {
                if (($handle = fopen($tempPath, 'r')) !== false) {
                    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                        // Support separator semicolon if needed
                        if (count($data) === 1 && strpos($data[0], ';') !== false) {
                            $data = explode(';', $data[0]);
                        }
                        $rows[] = $data;
                    }
                    fclose($handle);
                }
            } elseif (in_array($ext, ['xlsx', 'xls'])) {
                $spreadsheet = IOFactory::load($tempPath);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();
            } else {
                return redirect()->back()->with('error', 'Format file tidak didukung! Harap unggah .xlsx, .xls, atau .csv');
            }

            if (empty($rows)) {
                return redirect()->back()->with('error', 'File yang diunggah kosong!');
            }

            // Abaikan baris header jika kolom pertama bertuliskan No/Kode/Nama/Sapaan atau ber-BOM UTF-8
            $firstCell = strtolower(trim(preg_replace('/[\x00-\x1F\x7F\xEF\xBB\xBF]/', '', $rows[0][0] ?? '')));
            if ($firstCell === 'no' || $firstCell === 'kode' || strpos($firstCell, 'nama') !== false || strpos($firstCell, 'code') !== false || strpos($firstCell, 'sapaan') !== false) {
                array_shift($rows);
            }

            $imported = 0;
            foreach ($rows as $row) {
                // Kolom yang diharapkan:
                // Col 0: No / Kode (opsional)
                // Col 1: Sapaan (Prof./Dr./Ustadz/Bapak/Ibu)
                // Col 2: Nama Lengkap & Gelar (wajib)
                // Col 3: Asal Instansi / KOWPI
                // Col 4: Nomor WhatsApp (opsional)
                if (count($row) < 2) continue;

                $col0 = trim(preg_replace('/[\x00-\x1F\x7F\xEF\xBB\xBF]/', '', $row[0] ?? ''));
                $col1 = trim($row[1] ?? '');
                $col2 = trim($row[2] ?? '');
                $col3 = trim($row[3] ?? '');
                $col4 = trim($row[4] ?? '');

                // Deteksi letak nama lengkap
                if (!empty($col2)) {
                    $salutation = !empty($col1) ? $col1 : 'Bapak/Ibu';
                    $fullName = $col2;
                    $institution = $col3;
                    $phone = $col4;
                } elseif (!empty($col1)) {
                    $salutation = 'Bapak/Ibu';
                    $fullName = $col1;
                    $institution = $col2;
                    $phone = $col3;
                } else {
                    $salutation = 'Bapak/Ibu';
                    $fullName = $col0;
                    $institution = $col1;
                    $phone = $col2;
                }

                if (empty($fullName)) continue;

                // Abaikan jika ternyata baris ini adalah teks header
                if (stripos($fullName, 'Nama Lengkap') !== false || stripos($fullName, 'Gelar') !== false || strtolower($fullName) === 'nama') {
                    continue;
                }

                $code = $this->guestModel->getNextInvitedCode();
                $slug = preg_replace('/[^A-Za-z0-9_]/', '_', $code);
                $pdfFilename = "Undangan_Promosi_Doktor_Muhammad_Abu_Rivai_{$slug}.pdf";

                $this->guestModel->insert([
                    'guest_code'   => $code,
                    'salutation'   => $salutation,
                    'full_name'    => $fullName,
                    'institution'  => $institution,
                    'phone'        => $phone,
                    'guest_type'   => 'invited',
                    'pdf_filename' => $pdfFilename,
                    'is_present'   => 0,
                ]);
                $imported++;
            }

            return redirect()->to('/tamu')->with('success', "Berhasil mengimpor {$imported} data tamu undangan baru!");
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }

    /**
     * Unduh template impor tamu (Default: Microsoft Excel .xlsx resmi, atau CSV jika ?format=csv)
     */
    public function downloadTemplate()
    {
        $format = strtolower($this->request->getGet('format') ?? 'xlsx');

        $headers = ["No", "Sapaan", "Nama Lengkap & Gelar", "Asal Instansi / Lembaga / Cabang KOWPI", "Nomor WhatsApp"];
        $samples = [
            ["1", "Profesor", "Prof. Dr. H. Abdul Ghofur, M.Ag.", "Pakar Hukum Islam FIAI UII", "081234567890"],
            ["2", "Ustadz", "Ustadz H. Budi Setiawan, Lc., M.E.I.", "Ketua Umum DPP KOWPI", "081234567891"],
            ["3", "Bapak Notaris", "H. M. Ansori, S.H., M.Kn.", "Ikatan Notaris Indonesia (INI) DIY", "081234567892"],
            ["4", "Ibu Doktor", "Dr. Hj. Ratna Indrayanti, S.H., M.Hum.", "Fakultas Hukum UGM", "081234567893"],
            ["5", "Kyai", "K.H. Muhammad Hilmy Muhammad, M.A.", "Pondok Pesantren Krapyak Yogyakarta", "081234567894"],
        ];

        // Format CSV
        if ($format === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="Template_Impor_Daftar_Tamu_KOWPI_UII.csv"');

            $out = fopen('php://output', 'w');
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, $headers);
            foreach ($samples as $s) {
                fputcsv($out, $s);
            }
            fclose($out);
            exit();
        }

        // Format Microsoft Excel (.xlsx)
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Tamu');

        // Style Header
        $headerStyle = [
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0F2C59'], // Academic Navy
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'CBD5E1'],
                ],
            ],
        ];

        // Style Data Rows
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'CBD5E1'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        // Tulis Header di Baris 1
        $cols = ['A', 'B', 'C', 'D', 'E'];
        foreach ($headers as $idx => $title) {
            $sheet->setCellValue($cols[$idx] . '1', $title);
        }
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Tulis Data Contoh
        $rowNum = 2;
        foreach ($samples as $row) {
            foreach ($row as $idx => $val) {
                $cell = $cols[$idx] . $rowNum;
                $sheet->setCellValueExplicit($cell, (string)$val, DataType::TYPE_STRING);
            }
            $sheet->getStyle("A{$rowNum}:E{$rowNum}")->applyFromArray($dataStyle);
            $sheet->getStyle("A{$rowNum}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$rowNum}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension($rowNum)->setRowHeight(22);
            $rowNum++;
        }

        // Lebar Kolom
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(42);
        $sheet->getColumnDimension('D')->setWidth(44);
        $sheet->getColumnDimension('E')->setWidth(22);

        $filename = 'Template_Impor_Daftar_Tamu_KOWPI_UII.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    /**
     * Ekspor seluruh data tamu ke CSV
     */
    public function exportExcel()
    {
        $guests = $this->guestModel->orderBy('guest_type', 'ASC')
                                   ->orderBy('id', 'ASC')
                                   ->findAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Daftar_Tamu_Sidang_Promosi_Doktor_' . date('Ymd_His') . '.csv"');

        $out = fopen('php://output', 'w');
        fputs($out, "\xEF\xBB\xBF");
        fputcsv($out, [
            "Kode Tamu",
            "Tipe Tamu",
            "Sapaan",
            "Nama Lengkap & Gelar",
            "Instansi / Lembaga",
            "No. WhatsApp",
            "Status Kehadiran",
            "Waktu Check-In",
            "File Undangan PDF",
            "Ucapan / Doa"
        ]);

        foreach ($guests as $g) {
            fputcsv($out, [
                $g['guest_code'],
                $g['guest_type'] === 'invited' ? 'Tamu Undangan' : 'Walk-in (Dadakan)',
                $g['salutation'],
                $g['full_name'],
                $g['institution'],
                $g['phone'],
                $g['is_present'] ? 'Hadir' : 'Belum Hadir',
                $g['check_in_time'] ?: '-',
                $g['pdf_filename'],
                $g['wishes'] ?: '-'
            ]);
        }
        fclose($out);
        exit();
    }

    /**
     * Unduh 1 File PDF Gabungan (All-in-One Print-Ready) untuk seluruh tamu di lembaga tertentu
     */
    public function downloadPdfByInstitution()
    {
        $institution = trim($this->request->getGet('institution') ?? '');
        if (empty($institution)) {
            return redirect()->back()->with('error', 'Silakan pilih lembaga / instansi terlebih dahulu.');
        }

        $guests = $this->guestModel->where('institution', $institution)
                                   ->orderBy('id', 'ASC')
                                   ->findAll();

        if (empty($guests)) {
            return redirect()->back()->with('error', 'Tidak ditemukan tamu untuk lembaga: ' . esc($institution));
        }

        $settings = $this->settingsModel->getSettings();
        $pdfService = new PdfGeneratorService($settings);

        $cleanInst = preg_replace('/[^A-Za-z0-9_]/', '_', $institution);
        $filename = "Undangan_Kompilasi_{$cleanInst}_" . count($guests) . "_Tamu.pdf";

        $pdfString = $pdfService->generateMultiple($guests, $settings, 'S', null, $filename);

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($pdfString);
    }

    /**
     * Unduh Paket ZIP berisi seluruh file PDF personal untuk tamu di lembaga tertentu
     */
    public function downloadZipByInstitution()
    {
        $institution = trim($this->request->getGet('institution') ?? '');
        if (empty($institution)) {
            return redirect()->back()->with('error', 'Silakan pilih lembaga / instansi terlebih dahulu.');
        }

        $guests = $this->guestModel->where('institution', $institution)
                                   ->orderBy('id', 'ASC')
                                   ->findAll();

        if (empty($guests)) {
            return redirect()->back()->with('error', 'Tidak ditemukan tamu untuk lembaga: ' . esc($institution));
        }

        $settings = $this->settingsModel->getSettings();
        $pdfService = new PdfGeneratorService($settings);

        @set_time_limit(300);
        @ini_set('memory_limit', '512M');

        $cleanInst = preg_replace('/[^A-Za-z0-9_]/', '_', $institution);
        $zipFilename = "Undangan_Paket_{$cleanInst}_" . count($guests) . "_Tamu.zip";
        $uniqueId = bin2hex(random_bytes(6));
        $tempZipPath = WRITEPATH . 'cache/zip_' . time() . '_' . $uniqueId . '.tmp.zip';

        $zip = new ZipArchive();
        if ($zip->open($tempZipPath, ZipArchive::CREATE) !== true) {
            return redirect()->back()->with('error', 'Gagal membuat file arsip ZIP!');
        }

        $pdfDir = FCPATH . 'uploads/pdf';

        foreach ($guests as $g) {
            $slug = preg_replace('/[^A-Za-z0-9_]/', '_', $g['guest_code']);
            $filename = !empty($g['pdf_filename']) ? $g['pdf_filename'] : "Undangan_Promosi_Doktor_{$slug}.pdf";
            $existingPath = $pdfDir . '/' . $filename;

            if (file_exists($existingPath)) {
                $zip->addFile($existingPath, $filename);
            } else {
                $pdfContent = $pdfService->generate($g, $settings, 'S');
                $zip->addFromString($filename, $pdfContent);
            }
        }

        $zip->close();

        if (!file_exists($tempZipPath)) {
            return redirect()->back()->with('error', 'Gagal memproses file ZIP!');
        }

        $zipBinary = file_get_contents($tempZipPath);
        @unlink($tempZipPath);

        return $this->response->download($zipFilename, $zipBinary);
    }
}
