<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MeetingModel;
use App\Models\AttendanceModel;
use App\Models\SettingModel;

class DashboardController extends BaseController
{
    protected MeetingModel $meetingModel;
    protected AttendanceModel $attendanceModel;
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->meetingModel    = new MeetingModel();
        $this->attendanceModel = new AttendanceModel();
        $this->settingModel    = new SettingModel();
    }

    public function index()
    {
        $stats = $this->meetingModel->getDashboardStats();
        $settings = $this->settingModel->getSettings();

        // Spotlight meeting: ongoing or draft today/newest
        $activeMeeting = $this->meetingModel
            ->whereIn('status', ['ongoing', 'draft'])
            ->orderBy('meeting_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->first();

        if ($activeMeeting) {
            $activeMeeting = $this->meetingModel->getMeetingWithCounts($activeMeeting['id']);
        }

        // Recent meetings (limit 8)
        $recentMeetings = $this->meetingModel
            ->orderBy('meeting_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll(8);

        foreach ($recentMeetings as &$m) {
            $m = $this->meetingModel->getMeetingWithCounts($m['id']);
        }

        $data = [
            'title'          => 'Dashboard Notula & Presensi Rapat',
            'activeNav'      => 'dashboard',
            'stats'          => $stats,
            'activeMeeting'  => $activeMeeting,
            'recentMeetings' => $recentMeetings,
            'settings'       => $settings,
        ];

        return view('dashboard/index', $data);
    }
}
