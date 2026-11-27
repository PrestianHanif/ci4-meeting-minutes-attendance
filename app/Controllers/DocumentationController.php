<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MeetingModel;
use App\Models\DocumentationModel;
use App\Models\SettingModel;

class DocumentationController extends BaseController
{
    protected MeetingModel $meetingModel;
    protected DocumentationModel $docModel;
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->meetingModel = new MeetingModel();
        $this->docModel     = new DocumentationModel();
        $this->settingModel = new SettingModel();
    }

    /**
     * Galeri & Manajemen Dokumentasi Foto
     */
    public function index(int $meetingId)
    {
        $meeting = $this->meetingModel->getMeetingWithCounts($meetingId);
        if (!$meeting) {
            return redirect()->to(base_url('rapat'))->with('error', 'Rapat tidak ditemukan.');
        }

        $photos = $this->docModel->getByMeeting($meetingId);
        $settings = $this->settingModel->getSettings();

        $data = [
            'title'     => 'Dokumentasi Foto Rapat: ' . $meeting['title'],
            'activeNav' => 'meetings',
            'meeting'   => $meeting,
            'photos'    => $photos,
            'settings'  => $settings,
        ];

        return view('documentation/index', $data);
    }

    /**
     * Upload Foto Dokumentasi (Single or Multiple)
     */
    public function upload(int $meetingId)
    {
        $meeting = $this->meetingModel->find($meetingId);
        if (!$meeting) {
            return redirect()->back()->with('error', 'Rapat tidak ditemukan.');
        }

        $files = $this->request->getFiles();
        $caption = trim($this->request->getPost('caption') ?? '');

        $uploadedCount = 0;
        $docDir = FCPATH . 'uploads/photos';
        if (!is_dir($docDir)) {
            mkdir($docDir, 0777, true);
        }

        if (isset($files['photos'])) {
            $photoFiles = is_array($files['photos']) ? $files['photos'] : [$files['photos']];

            foreach ($photoFiles as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $ext = $file->getClientExtension();
                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])) {
                        $newName = 'doc_' . $meetingId . '_' . time() . '_' . mt_rand(100, 999) . '.' . $ext;
                        $file->move($docDir, $newName);

                        $this->docModel->insert([
                            'meeting_id' => $meetingId,
                            'file_path'  => 'uploads/photos/' . $newName,
                            'caption'    => !empty($caption) ? $caption : 'Dokumentasi Kegiatan Rapat KOWPI',
                            'taken_at'   => date('Y-m-d H:i:s'),
                        ]);
                        $uploadedCount++;
                    }
                }
            }
        }

        if ($uploadedCount > 0) {
            return redirect()->to(base_url("rapat/{$meetingId}/dokumentasi"))->with('success', "{$uploadedCount} foto dokumentasi berhasil diunggah!");
        }

        return redirect()->back()->with('error', 'Tidak ada foto valid yang diunggah.');
    }

    /**
     * Update Caption Foto
     */
    public function updateCaption(int $id)
    {
        $caption = trim($this->request->getPost('caption') ?? '');
        $doc = $this->docModel->find($id);

        if (!$doc) {
            return $this->response->setJSON(['success' => false, 'message' => 'Foto tidak ditemukan'])->setStatusCode(404);
        }

        $this->docModel->update($id, ['caption' => $caption]);

        return $this->response->setJSON(['success' => true, 'message' => 'Keterangan foto diperbarui.']);
    }

    /**
     * Hapus Foto Dokumentasi
     */
    public function delete(int $id)
    {
        $doc = $this->docModel->find($id);
        if (!$doc) {
            return redirect()->back()->with('error', 'Foto tidak ditemukan.');
        }

        $meetingId = $doc['meeting_id'];
        $filePath = FCPATH . $doc['file_path'];

        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        $this->docModel->delete($id);

        return redirect()->to(base_url("rapat/{$meetingId}/dokumentasi"))->with('success', 'Foto dokumentasi berhasil dihapus.');
    }
}

