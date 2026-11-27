<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MeetingModel;
use App\Models\AttendanceModel;
use App\Models\MeetingMinutesModel;
use App\Models\DocumentationModel;
use App\Models\SettingModel;

class MeetingController extends BaseController
{
    protected MeetingModel $meetingModel;
    protected AttendanceModel $attendanceModel;
    protected MeetingMinutesModel $minutesModel;
    protected DocumentationModel $docModel;
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->meetingModel    = new MeetingModel();
        $this->attendanceModel = new AttendanceModel();
        $this->minutesModel    = new MeetingMinutesModel();
        $this->docModel        = new DocumentationModel();
        $this->settingModel    = new SettingModel();
    }

    /**
     * Daftar Semua Rapat
     */
    public function index()
    {
        $status   = $this->request->getGet('status');
        $category = $this->request->getGet('category');
        $search   = $this->request->getGet('q');

        $query = $this->meetingModel;

        if (!empty($status)) {
            $query = $query->where('status', $status);
        }
        if (!empty($category)) {
            $query = $query->where('category', $category);
        }
        if (!empty($search)) {
            $query = $query->groupStart()
                           ->like('title', $search)
                           ->orLike('meeting_code', $search)
                           ->orLike('leader_name', $search)
                           ->orLike('agenda', $search)
                           ->groupEnd();
        }

        $meetings = $query->orderBy('meeting_date', 'DESC')
                          ->orderBy('id', 'DESC')
                          ->findAll();

        foreach ($meetings as &$m) {
            $m = $this->meetingModel->getMeetingWithCounts($m['id']);
        }

        $settings = $this->settingModel->getSettings();

        $data = [
            'title'     => 'Agenda & Notula Rapat KOWPI',
            'activeNav' => 'meetings',
            'meetings'  => $meetings,
            'status'    => $status,
            'category'  => $category,
            'search'    => $search,
            'settings'  => $settings,
        ];

        return view('meetings/index', $data);
    }

    /**
     * Form Tambah Rapat Baru
     */
    public function create()
    {
        $settings = $this->settingModel->getSettings();
        $code = $this->meetingModel->generateMeetingCode();

        $data = [
            'title'     => 'Jadwalkan Rapat Baru - KOWPI',
            'activeNav' => 'meetings',
            'code'      => $code,
            'settings'  => $settings,
        ];

        return view('meetings/create', $data);
    }

    /**
     * Simpan Rapat Baru
     */
    public function store()
    {
        $title       = trim($this->request->getPost('title') ?? '');
        $category    = trim($this->request->getPost('category') ?? 'Rapat Koordinasi');
        $meetingDate = trim($this->request->getPost('meeting_date') ?? date('Y-m-d'));
        $startTime   = trim($this->request->getPost('start_time') ?? '09:00');
        $endTime     = trim($this->request->getPost('end_time') ?? '12:00');
        $meetingType = trim($this->request->getPost('meeting_type') ?? 'offline');
        $location    = trim($this->request->getPost('location') ?? 'Ruang Rapat Utama Gedung KOWPI Center');
        $meetingLink = trim($this->request->getPost('meeting_link') ?? '');
        $leaderName  = trim($this->request->getPost('leader_name') ?? '');
        $leaderTitle = trim($this->request->getPost('leader_title') ?? 'Pimpinan Rapat');
        $notaryName  = trim($this->request->getPost('notary_name') ?? '');
        $agenda      = trim($this->request->getPost('agenda') ?? '');
        $status      = trim($this->request->getPost('status') ?? 'ongoing');

        if (empty($title) || empty($leaderName) || empty($notaryName) || empty($agenda)) {
            return redirect()->back()->withInput()->with('error', 'Mohon lengkapi judul rapat, pimpinan, notulis, dan agenda.');
        }

        $code = $this->meetingModel->generateMeetingCode();

        $meetingData = [
            'meeting_code'     => $code,
            'title'            => $title,
            'category'         => $category,
            'meeting_date'     => $meetingDate,
            'start_time'       => $startTime,
            'end_time'         => $endTime,
            'meeting_type'     => $meetingType,
            'location'         => $location,
            'meeting_link'     => !empty($meetingLink) ? $meetingLink : null,
            'leader_name'      => $leaderName,
            'leader_title'     => $leaderTitle,
            'notary_name'      => $notaryName,
            'agenda'           => $agenda,
            'status'           => $status,
            'is_presence_open' => 1,
        ];

        $meetingId = $this->meetingModel->insert($meetingData, true);

        // Inisialisasi draft Notula
        $this->minutesModel->getOrInit($meetingId);

        return redirect()->to(base_url('rapat/detail/' . $meetingId))->with('success', "Rapat berhasil dibuat dengan kode resmi {$code}!");
    }

    /**
     * Hub & Detail Lengkap Rapat
     */
    public function detail(int $id)
    {
        $meeting = $this->meetingModel->getMeetingWithCounts($id);
        if (!$meeting) {
            return redirect()->to(base_url('rapat'))->with('error', 'Data rapat tidak ditemukan.');
        }

        $settings = $this->settingModel->getSettings();
        $attendances = $this->attendanceModel->getByMeeting($id);
        $minutes = $this->minutesModel->getOrInit($id);
        $documentations = $this->docModel->getByMeeting($id);

        $data = [
            'title'          => 'Detail Rapat: ' . $meeting['title'],
            'activeNav'      => 'meetings',
            'meeting'        => $meeting,
            'attendances'    => $attendances,
            'minutes'        => $minutes,
            'documentations' => $documentations,
            'settings'       => $settings,
        ];

        return view('meetings/detail', $data);
    }

    /**
     * Form Edit Rapat
     */
    public function edit(int $id)
    {
        $meeting = $this->meetingModel->find($id);
        if (!$meeting) {
            return redirect()->to(base_url('rapat'))->with('error', 'Data rapat tidak ditemukan.');
        }

        $settings = $this->settingModel->getSettings();

        $data = [
            'title'     => 'Edit Agenda Rapat: ' . $meeting['meeting_code'],
            'activeNav' => 'meetings',
            'meeting'   => $meeting,
            'settings'  => $settings,
        ];

        return view('meetings/edit', $data);
    }

    /**
     * Update Data Rapat
     */
    public function update(int $id)
    {
        $meeting = $this->meetingModel->find($id);
        if (!$meeting) {
            return redirect()->to(base_url('rapat'))->with('error', 'Data rapat tidak ditemukan.');
        }

        $title       = trim($this->request->getPost('title') ?? '');
        $category    = trim($this->request->getPost('category') ?? 'Rapat Koordinasi');
        $meetingDate = trim($this->request->getPost('meeting_date') ?? $meeting['meeting_date']);
        $startTime   = trim($this->request->getPost('start_time') ?? $meeting['start_time']);
        $endTime     = trim($this->request->getPost('end_time') ?? $meeting['end_time']);
        $meetingType = trim($this->request->getPost('meeting_type') ?? $meeting['meeting_type']);
        $location    = trim($this->request->getPost('location') ?? $meeting['location']);
        $meetingLink = trim($this->request->getPost('meeting_link') ?? '');
        $leaderName  = trim($this->request->getPost('leader_name') ?? '');
        $leaderTitle = trim($this->request->getPost('leader_title') ?? 'Pimpinan Rapat');
        $notaryName  = trim($this->request->getPost('notary_name') ?? '');
        $agenda      = trim($this->request->getPost('agenda') ?? '');
        $status      = trim($this->request->getPost('status') ?? $meeting['status']);

        if (empty($title) || empty($leaderName) || empty($notaryName) || empty($agenda)) {
            return redirect()->back()->withInput()->with('error', 'Data wajib belum lengkap.');
        }

        $updateData = [
            'title'        => $title,
            'category'     => $category,
            'meeting_date' => $meetingDate,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
            'meeting_type' => $meetingType,
            'location'     => $location,
            'meeting_link' => !empty($meetingLink) ? $meetingLink : null,
            'leader_name'  => $leaderName,
            'leader_title' => $leaderTitle,
            'notary_name'  => $notaryName,
            'agenda'       => $agenda,
            'status'       => $status,
        ];

        $this->meetingModel->update($id, $updateData);

        return redirect()->to(base_url('rapat/detail/' . $id))->with('success', 'Informasi rapat berhasil diperbarui.');
    }

    /**
     * Toggle Buka / Kunci Presensi
     */
    public function togglePresence(int $id)
    {
        $meeting = $this->meetingModel->find($id);
        if (!$meeting) {
            return redirect()->back()->with('error', 'Rapat tidak ditemukan.');
        }

        $newVal = $meeting['is_presence_open'] ? 0 : 1;
        $this->meetingModel->update($id, ['is_presence_open' => $newVal]);

        $msg = $newVal ? 'Presensi rapat dibuka kembali.' : 'Presensi rapat resmi ditutup / dikunci.';
        return redirect()->back()->with('success', $msg);
    }

    /**
     * Ganti Status Rapat
     */
    public function changeStatus(int $id)
    {
        $status = $this->request->getPost('status');
        if (!in_array($status, ['draft', 'ongoing', 'completed', 'archived'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $update = ['status' => $status];
        if ($status === 'archived') {
            $update['archived_at'] = date('Y-m-d H:i:s');
            $update['archived_by'] = session()->get('admin_name') ?? 'Admin';
            $update['is_presence_open'] = 0;
        }

        $this->meetingModel->update($id, $update);
        return redirect()->back()->with('success', "Status rapat berhasil diubah menjadi: " . strtoupper($status));
    }

    /**
     * Hapus Rapat Beserta Dokumen Terkait
     */
    public function delete(int $id)
    {
        $meeting = $this->meetingModel->find($id);
        if (!$meeting) {
            return redirect()->to(base_url('rapat'))->with('error', 'Rapat tidak ditemukan.');
        }

        // Hapus file tanda tangan kehadiran
        $attendances = $this->attendanceModel->where('meeting_id', $id)->findAll();
        foreach ($attendances as $att) {
            if (!empty($att['signature_image']) && file_exists(FCPATH . $att['signature_image'])) {
                @unlink(FCPATH . $att['signature_image']);
            }
        }

        // Hapus foto dokumentasi
        $docs = $this->docModel->where('meeting_id', $id)->findAll();
        foreach ($docs as $d) {
            if (!empty($d['file_path']) && file_exists(FCPATH . $d['file_path'])) {
                @unlink(FCPATH . $d['file_path']);
            }
        }

        $this->meetingModel->delete($id);

        return redirect()->to(base_url('rapat'))->with('success', 'Rapat dan seluruh berkasnya berhasil dihapus.');
    }
}

