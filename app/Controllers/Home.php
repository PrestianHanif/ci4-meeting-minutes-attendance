<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MeetingModel;
use App\Models\AttendanceModel;
use App\Models\MeetingMinutesModel;
use App\Models\DocumentationModel;
use App\Models\SettingModel;

class Home extends BaseController
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
     * Homepage Publik Terpadu KOWPI
     * - Section 1: Hero & Spotlight Rapat Aktif Hari Ini + Formulir Presensi TTD Digital
     * - Section 2: Direktori Rapat-Rapat Sebelumnya & Notula Resmi
     */
    public function index()
    {
        $settings = $this->settingModel->getSettings();

        // 1. Rapat Aktif / Hari Ini (Spotlight)
        $activeMeeting = $this->meetingModel
            ->whereIn('status', ['ongoing', 'draft'])
            ->orderBy('meeting_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->first();

        $activeAttendances = [];
        if ($activeMeeting) {
            $activeMeeting = $this->meetingModel->getMeetingWithCounts($activeMeeting['id']);
            $activeMeeting['photos'] = $this->docModel->getByMeeting($activeMeeting['id']);
            $activeAttendances = $this->attendanceModel->getByMeeting($activeMeeting['id']);
        }

        // 2. Direktori Rapat-Rapat Sebelumnya (Semua rapat selain rapat aktif utama)
        $category = $this->request->getGet('category');
        $search   = $this->request->getGet('q');

        $query = $this->meetingModel;
        if ($activeMeeting) {
            $query = $query->where('id !=', $activeMeeting['id']);
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

        $previousMeetings = $query->orderBy('meeting_date', 'DESC')
                                  ->orderBy('id', 'DESC')
                                  ->findAll();

        foreach ($previousMeetings as &$m) {
            $m = $this->meetingModel->getMeetingWithCounts($m['id']);
            $m['photos'] = $this->docModel->getByMeeting($m['id']);
        }

        // Statistik Keseluruhan
        $totalMeetings = $this->meetingModel->countAllResults();
        $db = \Config\Database::connect();
        $totalAttendees = $db->table('attendances')->countAllResults();
        $totalPhotos = $db->table('meeting_documentations')->countAllResults();

        $data = [
            'title'             => 'Sistem Notula & Daftar Hadir Rapat Resmi - ' . ($settings['org_short'] ?? 'KOWPI'),
            'settings'          => $settings,
            'activeMeeting'     => $activeMeeting,
            'activeAttendances' => $activeAttendances,
            'previousMeetings'  => $previousMeetings,
            'category'          => $category,
            'search'            => $search,
            'stats'             => [
                'total_meetings'  => $totalMeetings,
                'total_attendees' => $totalAttendees,
                'total_photos'    => $totalPhotos,
            ]
        ];

        return view('home/index', $data);
    }

    /**
     * AJAX / Modal Info Detail Rapat & Notula untuk Publik
     */
    public function publicMeetingDetail(int $id)
    {
        $meeting = $this->meetingModel->getMeetingWithCounts($id);
        if (!$meeting) {
            return $this->response->setJSON(['success' => false, 'message' => 'Rapat tidak ditemukan'])->setStatusCode(404);
        }

        $minutes = $this->minutesModel->where('meeting_id', $id)->first();
        $attendances = $this->attendanceModel->getByMeeting($id);
        $photos = $this->docModel->getByMeeting($id);

        $actionItems = [];
        if (!empty($minutes['action_items'])) {
            $decoded = json_decode($minutes['action_items'], true);
            if (is_array($decoded)) {
                $actionItems = $decoded;
            }
        }

        return $this->response->setJSON([
            'success'     => true,
            'meeting'     => $meeting,
            'minutes'     => $minutes,
            'actionItems' => $actionItems,
            'attendances' => $attendances,
            'photos'      => $photos,
        ]);
    }
}
