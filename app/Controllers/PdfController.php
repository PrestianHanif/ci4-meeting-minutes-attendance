<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuestModel;
use App\Models\EventSettingsModel;
use App\Services\PdfGeneratorService;
use ZipArchive;

class PdfController extends BaseController
{
    protected GuestModel $guestModel;
    protected EventSettingsModel $settingsModel;

    public function __construct()
    {
        $this->guestModel = new GuestModel();
        $this->settingsModel = new EventSettingsModel();
    }

    /**
     * Halaman manajemen generator massal & export ZIP
     */
    public function batchManager()
    {
        $totalGuests = $this->guestModel->countAllResults();
        $totalInvited = $this->guestModel->where('guest_type', 'invited')->countAllResults();
        
        $pdfDir = FCPATH . 'uploads/pdf';
        $existingPdfs = is_dir($pdfDir) ? glob($pdfDir . '/*.pdf') : [];
        $generatedCount = count($existingPdfs);

        $data = [
            'title'          => 'Bulk PDF Generator & ZIP Exporter — Undangan Sidang',
            'activeNav'      => 'pdf_manager',
            'totalGuests'    => $totalGuests,
            'totalInvited'   => $totalInvited,
            'generatedCount' => $generatedCount,
            'settings'       => $this->settingsModel->getSettings(),
        ];

        return view('pdf_manager/index', $data);
    }

    /**
     * Preview PDF satuan di tab baru
     */
    public function previewSingle($id)
    {
        $guest = $this->guestModel->find($id);
        if (!$guest) {
            return $this->response->setStatusCode(404)->setBody('Data tamu tidak ditemukan.');
        }

        $settings = $this->settingsModel->getSettings();
        $pdfService = new PdfGeneratorService($settings);

        $pdfString = $pdfService->generate($guest, $settings, 'S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $guest['pdf_filename'] . '"')
            ->setBody($pdfString);
    }

    /**
     * Unduh PDF satuan per tamu
     */
    public function generateSingle($id)
    {
        $guest = $this->guestModel->find($id);
        if (!$guest) {
            return redirect()->back()->with('error', 'Data tamu tidak ditemukan.');
        }

        $settings = $this->settingsModel->getSettings();
        $pdfService = new PdfGeneratorService($settings);

        $pdfString = $pdfService->generate($guest, $settings, 'S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $guest['pdf_filename'] . '"')
            ->setBody($pdfString);
    }

    /**
     * AJAX Batch Processor (5 PDF per siklus)
     */
    public function batchProcess()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request'])->setStatusCode(400);
        }

        $offset = (int)($this->request->getPost('offset') ?? 0);
        $limit = 5; // 5 PDF per cycle to prevent timeout and memory peak

        $total = $this->guestModel->countAllResults();
        $guests = $this->guestModel->orderBy('id', 'ASC')
                                   ->findAll($limit, $offset);

        $settings = $this->settingsModel->getSettings();
        $pdfService = new PdfGeneratorService($settings);

        $pdfDir = FCPATH . 'uploads/pdf';
        if (!is_dir($pdfDir)) {
            mkdir($pdfDir, 0777, true);
        }

        $processedItems = [];

        foreach ($guests as $g) {
            $slug = preg_replace('/[^A-Za-z0-9_]/', '_', $g['guest_code']);
            $filename = "Undangan_Promosi_Doktor_Muhammad_Abu_Rivai_{$slug}.pdf";
            $savePath = $pdfDir . '/' . $filename;

            try {
                $pdfService->generate($g, $settings, 'F', $savePath);
                
                // Update filename di database jika belum tersimpan
                if ($g['pdf_filename'] !== $filename) {
                    $this->guestModel->update($g['id'], ['pdf_filename' => $filename]);
                }

                $fileSize = file_exists($savePath) ? round(filesize($savePath) / 1024) : 0;

                $processedItems[] = [
                    'id'       => $g['id'],
                    'code'     => $g['guest_code'],
                    'name'     => $g['full_name'],
                    'filename' => $filename,
                    'size_kb'  => $fileSize,
                    'status'   => 'success',
                ];
            } catch (\Throwable $e) {
                $processedItems[] = [
                    'id'       => $g['id'],
                    'code'     => $g['guest_code'],
                    'name'     => $g['full_name'],
                    'filename' => $filename,
                    'size_kb'  => 0,
                    'status'   => 'error: ' . $e->getMessage(),
                ];
            }
        }

        $newOffset = $offset + count($guests);
        $isDone = ($newOffset >= $total) || count($guests) === 0;

        return $this->response->setJSON([
            'success'     => true,
            'processed'   => count($processedItems),
            'offset'      => $offset,
            'nextOffset'  => $newOffset,
            'total'       => $total,
            'isDone'      => $isDone,
            'items'       => $processedItems,
            'progress'    => $total > 0 ? min(100, round(($newOffset / $total) * 100)) : 100,
        ]);
    }

    /**
     * Unduh bundel ZIP seluruh PDF yang telah digenerate
     */
    public function downloadZip()
    {
        $pdfDir = FCPATH . 'uploads/pdf';
        if (!is_dir($pdfDir)) {
            return redirect()->back()->with('error', 'Belum ada file PDF yang digenerate!');
        }

        $pdfFiles = glob($pdfDir . '/*.pdf');
        if (empty($pdfFiles)) {
            return redirect()->back()->with('error', 'Belum ada file PDF yang digenerate. Silakan klik "Mulai Generate Massal" terlebih dahulu.');
        }

        $zipFilename = 'Undangan_Sidang_Muhammad_Abu_Rivai_Semua_Tamu.zip';
        $uniqueId = bin2hex(random_bytes(6));
        $tempZipPath = WRITEPATH . 'cache/zip_' . time() . '_' . $uniqueId . '.tmp.zip';

        $zip = new ZipArchive();
        if ($zip->open($tempZipPath, ZipArchive::CREATE) !== true) {
            return redirect()->back()->with('error', 'Gagal membuat file arsip ZIP!');
        }

        foreach ($pdfFiles as $file) {
            $zip->addFile($file, basename($file));
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
