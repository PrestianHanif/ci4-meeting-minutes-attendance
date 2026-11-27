<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MeetingModel;
use App\Models\AttendanceModel;
use App\Models\MeetingMinutesModel;
use App\Models\DocumentationModel;
use App\Models\SettingModel;

class ArchiveController extends BaseController
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
     * Direktori Arsip Notula & Rapat KOWPI
     */
    public function index()
    {
        $year     = $this->request->getGet('year');
        $month    = $this->request->getGet('month');
        $category = $this->request->getGet('category');
        $search   = $this->request->getGet('q');

        $query = $this->meetingModel->where('status', 'archived');

        if (!empty($year)) {
            $query = $query->where('YEAR(meeting_date)', $year);
        }
        if (!empty($month)) {
            $query = $query->where('MONTH(meeting_date)', $month);
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

        $archives = $query->orderBy('meeting_date', 'DESC')
                          ->orderBy('id', 'DESC')
                          ->findAll();

        foreach ($archives as &$a) {
            $a = $this->meetingModel->getMeetingWithCounts($a['id']);
        }

        // Available years for dropdown
        $db = \Config\Database::connect();
        $years = $db->table('meetings')
                    ->select('DISTINCT YEAR(meeting_date) as y')
                    ->where('status', 'archived')
                    ->orderBy('y', 'DESC')
                    ->get()->getResultArray();

        // Also get completed meetings that can be archived right away
        $readyToArchive = $this->meetingModel
            ->where('status', 'completed')
            ->orderBy('meeting_date', 'DESC')
            ->findAll();

        $settings = $this->settingModel->getSettings();

        $data = [
            'title'          => 'Direktori Arsip Notula & Berkas Rapat KOWPI',
            'activeNav'      => 'archive',
            'archives'       => $archives,
            'readyToArchive' => $readyToArchive,
            'years'          => array_column($years, 'y'),
            'selectedYear'   => $year,
            'selectedMonth'  => $month,
            'category'       => $category,
            'search'         => $search,
            'settings'       => $settings,
        ];

        return view('archive/index', $data);
    }

    /**
     * Proses Pengarsipan Rapat Resmi
     */
    public function archiveMeeting(int $id)
    {
        $meeting = $this->meetingModel->find($id);
        if (!$meeting) {
            return redirect()->back()->with('error', 'Rapat tidak ditemukan.');
        }

        $notes = trim($this->request->getPost('archive_notes') ?? '');
        $adminName = session()->get('admin_name') ?? 'Admin';

        $this->meetingModel->update($id, [
            'status'           => 'archived',
            'is_presence_open' => 0, // Kunci presensi
            'archived_at'      => date('Y-m-d H:i:s'),
            'archived_by'      => $adminName,
            'archive_notes'    => !empty($notes) ? $notes : 'Diarsipkan resmi oleh ' . $adminName,
        ]);

        return redirect()->to(base_url('arsip'))->with('success', "Rapat {$meeting['meeting_code']} berhasil dimasukkan ke Direktori Arsip Resmi.");
    }

    /**
     * Buka Kunci Arsip (Kembalikan ke Selesai)
     */
    public function unarchiveMeeting(int $id)
    {
        $meeting = $this->meetingModel->find($id);
        if (!$meeting) {
            return redirect()->back()->with('error', 'Rapat tidak ditemukan.');
        }

        $this->meetingModel->update($id, [
            'status'        => 'completed',
            'archive_notes' => null,
        ]);

        return redirect()->to(base_url('arsip'))->with('info', "Status arsip rapat {$meeting['meeting_code']} telah dibuka kembali.");
    }

    /**
     * Konsolidasi Berkas Arsip Rapat (Notula + Presensi Ber-TTD + Dokumentasi)
     */
    public function bundleView(int $id)
    {
        $meeting = $this->meetingModel->getMeetingWithCounts($id);
        if (!$meeting) {
            return redirect()->to(base_url('arsip'))->with('error', 'Data arsip tidak ditemukan.');
        }

        $settings = $this->settingModel->getSettings();
        $minutes = $this->minutesModel->getOrInit($id);
        $attendances = $this->attendanceModel->getByMeeting($id);
        $photos = $this->docModel->getByMeeting($id);

        $actionItems = [];
        if (!empty($minutes['action_items'])) {
            $decoded = json_decode($minutes['action_items'], true);
            if (is_array($decoded)) {
                $actionItems = $decoded;
            }
        }

        $data = [
            'title'       => 'Berkas Arsip: ' . $meeting['meeting_code'] . ' - ' . $meeting['title'],
            'activeNav'   => 'archive',
            'meeting'     => $meeting,
            'minutes'     => $minutes,
            'actionItems' => $actionItems,
            'attendances' => $attendances,
            'photos'      => $photos,
            'settings'    => $settings,
        ];

        return view('archive/bundle', $data);
    }
}

