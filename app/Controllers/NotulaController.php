<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MeetingModel;
use App\Models\MeetingMinutesModel;
use App\Models\SettingModel;
use App\Models\AttendanceModel;

class NotulaController extends BaseController
{
    protected MeetingModel $meetingModel;
    protected MeetingMinutesModel $minutesModel;
    protected SettingModel $settingModel;
    protected AttendanceModel $attendanceModel;

    public function __construct()
    {
        $this->meetingModel    = new MeetingModel();
        $this->minutesModel    = new MeetingMinutesModel();
        $this->settingModel    = new SettingModel();
        $this->attendanceModel = new AttendanceModel();
    }

    /**
     * Editor Notula Rapat Lengkap
     */
    public function edit(int $meetingId)
    {
        $meeting = $this->meetingModel->getMeetingWithCounts($meetingId);
        if (!$meeting) {
            return redirect()->to(base_url('rapat'))->with('error', 'Rapat tidak ditemukan.');
        }

        $minutes = $this->minutesModel->getOrInit($meetingId);
        $settings = $this->settingModel->getSettings();

        // Parse action items
        $actionItems = [];
        if (!empty($minutes['action_items'])) {
            $decoded = json_decode($minutes['action_items'], true);
            if (is_array($decoded)) {
                $actionItems = $decoded;
            }
        }

        $data = [
            'title'       => 'Tulis / Edit Notula: ' . $meeting['title'],
            'activeNav'   => 'meetings',
            'meeting'     => $meeting,
            'minutes'     => $minutes,
            'actionItems' => $actionItems,
            'settings'    => $settings,
        ];

        return view('notula/edit', $data);
    }

    /**
     * Simpan Notula
     */
    public function save(int $meetingId)
    {
        $meeting = $this->meetingModel->find($meetingId);
        if (!$meeting) {
            return redirect()->back()->with('error', 'Rapat tidak ditemukan.');
        }

        $minutes = $this->minutesModel->getOrInit($meetingId);

        $openingNotes = trim($this->request->getPost('opening_notes') ?? '');
        $discussion   = trim($this->request->getPost('discussion') ?? '');
        $decisions    = trim($this->request->getPost('decisions') ?? '');
        $closingNotes = trim($this->request->getPost('closing_notes') ?? '');
        $includeStamp = $this->request->getPost('include_stamp') ? 1 : 0;

        // Parse action items arrays from POST
        $tasks     = $this->request->getPost('action_task') ?? [];
        $pics      = $this->request->getPost('action_pic') ?? [];
        $deadlines = $this->request->getPost('action_deadline') ?? [];
        $statuses  = $this->request->getPost('action_status') ?? [];

        $actionItems = [];
        if (is_array($tasks)) {
            for ($i = 0; $i < count($tasks); $i++) {
                if (!empty(trim($tasks[$i]))) {
                    $actionItems[] = [
                        'task'     => trim($tasks[$i]),
                        'pic'      => trim($pics[$i] ?? ''),
                        'deadline' => trim($deadlines[$i] ?? ''),
                        'status'   => trim($statuses[$i] ?? 'Dalam Proses'),
                    ];
                }
            }
        }

        $updateData = [
            'opening_notes' => $openingNotes,
            'discussion'    => $discussion,
            'decisions'     => $decisions,
            'action_items'  => json_encode($actionItems, JSON_UNESCAPED_UNICODE),
            'closing_notes' => $closingNotes,
            'include_stamp' => $includeStamp,
        ];

        // Process Signatures if passed directly
        $sigLeader = $this->request->getPost('sig_leader_data');
        if (!empty($sigLeader) && strpos($sigLeader, 'data:image') !== false) {
            $path = $this->storeSignature($sigLeader, 'sig_leader_' . $meetingId);
            if ($path) {
                $updateData['leader_signature'] = $path;
                $updateData['is_signed_leader'] = 1;
            }
        }

        $sigNotary = $this->request->getPost('sig_notary_data');
        if (!empty($sigNotary) && strpos($sigNotary, 'data:image') !== false) {
            $path = $this->storeSignature($sigNotary, 'sig_notary_' . $meetingId);
            if ($path) {
                $updateData['notary_signature'] = $path;
                $updateData['is_signed_notary'] = 1;
            }
        }

        $this->minutesModel->update($minutes['id'], $updateData);

        return redirect()->to(base_url("rapat/{$meetingId}/notula"))->with('success', 'Notula rapat berhasil disimpan!');
    }

    /**
     * AJAX Simpan TTD Digital Pimpinan / Notulis
     */
    public function saveSignature(int $meetingId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request'])->setStatusCode(400);
        }

        $role    = $this->request->getPost('role'); // 'leader' or 'notary'
        $sigData = $this->request->getPost('signature_data');

        if (!in_array($role, ['leader', 'notary']) || empty($sigData)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Parameter tidak valid'])->setStatusCode(422);
        }

        $minutes = $this->minutesModel->getOrInit($meetingId);
        $prefix = 'sig_' . $role . '_' . $meetingId;
        $path = $this->storeSignature($sigData, $prefix);

        if (!$path) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memproses tanda tangan'])->setStatusCode(500);
        }

        $field = ($role === 'leader') ? 'leader_signature' : 'notary_signature';
        $flag  = ($role === 'leader') ? 'is_signed_leader' : 'is_signed_notary';

        $this->minutesModel->update($minutes['id'], [
            $field => $path,
            $flag  => 1,
        ]);

        return $this->response->setJSON([
            'success'   => true,
            'message'   => 'Tanda tangan digital ' . ($role === 'leader' ? 'Pimpinan Rapat' : 'Notulis') . ' berhasil disimpan!',
            'path'      => base_url($path),
        ]);
    }

    /**
     * Preview Dokumen Notula Resmi
     */
    public function view(int $meetingId)
    {
        $meeting = $this->meetingModel->getMeetingWithCounts($meetingId);
        if (!$meeting) {
            return redirect()->to(base_url('rapat'))->with('error', 'Rapat tidak ditemukan.');
        }

        $minutes = $this->minutesModel->getOrInit($meetingId);
        $settings = $this->settingModel->getSettings();
        $attendances = $this->attendanceModel->getByMeeting($meetingId);

        $actionItems = [];
        if (!empty($minutes['action_items'])) {
            $decoded = json_decode($minutes['action_items'], true);
            if (is_array($decoded)) {
                $actionItems = $decoded;
            }
        }

        $data = [
            'title'       => 'Dokumen Notula Resmi: ' . $meeting['title'],
            'activeNav'   => 'meetings',
            'meeting'     => $meeting,
            'minutes'     => $minutes,
            'actionItems' => $actionItems,
            'attendances' => $attendances,
            'settings'    => $settings,
        ];

        return view('notula/view', $data);
    }

    /**
     * Helper save base64 signature
     */
    protected function storeSignature(string $base64Data, string $prefix): ?string
    {
        $sigDir = FCPATH . 'uploads/signatures';
        if (!is_dir($sigDir)) {
            mkdir($sigDir, 0777, true);
        }

        $cleanData = preg_replace('#^data:image/\w+;base64,#i', '', $base64Data);
        $cleanData = str_replace(' ', '+', $cleanData);
        $decoded = base64_decode($cleanData);

        if (!$decoded) {
            return null;
        }

        $filename = $prefix . '_' . time() . '.png';
        $fullPath = $sigDir . '/' . $filename;
        file_put_contents($fullPath, $decoded);

        return 'uploads/signatures/' . $filename;
    }
}

