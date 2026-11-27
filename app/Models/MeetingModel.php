<?php

namespace App\Models;

use CodeIgniter\Model;

class MeetingModel extends Model
{
    protected $table            = 'meetings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'meeting_code',
        'title',
        'category',
        'meeting_date',
        'start_time',
        'end_time',
        'meeting_type',
        'location',
        'meeting_link',
        'leader_name',
        'leader_title',
        'notary_name',
        'agenda',
        'status',
        'is_presence_open',
        'archived_at',
        'archived_by',
        'archive_notes',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Generate unique meeting code: KOWPI-RPT-YYYYMM-XXX
     */
    public function generateMeetingCode(): string
    {
        $prefix = 'KOWPI-RPT-' . date('Ym') . '-';
        $count = $this->where('meeting_date >=', date('Y-m-01'))
                      ->where('meeting_date <=', date('Y-m-t'))
                      ->countAllResults();
        $seq = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        
        $candidate = $prefix . $seq;
        // ensure unique
        while ($this->where('meeting_code', $candidate)->first()) {
            $count++;
            $seq = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
            $candidate = $prefix . $seq;
        }
        return $candidate;
    }

    /**
     * Get meeting with full counts (attendances, photos, has minutes)
     */
    public function getMeetingWithCounts(int $id): ?array
    {
        $meeting = $this->find($id);
        if (!$meeting) {
            return null;
        }

        $db = \Config\Database::connect();
        
        // Attendance counts
        $attRow = $db->table('attendances')
            ->select('
                COUNT(*) as total_attendance,
                SUM(CASE WHEN attendance_status IN ("hadir_offline", "hadir_online") THEN 1 ELSE 0 END) as total_present,
                SUM(CASE WHEN attendance_status = "hadir_offline" THEN 1 ELSE 0 END) as total_offline,
                SUM(CASE WHEN attendance_status = "hadir_online" THEN 1 ELSE 0 END) as total_online,
                SUM(CASE WHEN attendance_status = "izin" THEN 1 ELSE 0 END) as total_izin,
                SUM(CASE WHEN attendance_status = "sakit" THEN 1 ELSE 0 END) as total_sakit
            ')
            ->where('meeting_id', $id)
            ->get()->getRowArray();

        $meeting['total_attendance'] = (int)($attRow['total_attendance'] ?? 0);
        $meeting['total_present']    = (int)($attRow['total_present'] ?? 0);
        $meeting['total_offline']    = (int)($attRow['total_offline'] ?? 0);
        $meeting['total_online']     = (int)($attRow['total_online'] ?? 0);
        $meeting['total_izin']       = (int)($attRow['total_izin'] ?? 0);
        $meeting['total_sakit']      = (int)($attRow['total_sakit'] ?? 0);

        // Photo documentation count
        $meeting['total_photos'] = $db->table('meeting_documentations')
            ->where('meeting_id', $id)
            ->countAllResults();

        // Minutes existence
        $minutes = $db->table('meeting_minutes')
            ->where('meeting_id', $id)
            ->get()->getRowArray();
        $meeting['has_minutes'] = !empty($minutes);
        $meeting['minutes'] = $minutes;

        return $meeting;
    }

    /**
     * Get statistics for dashboard
     */
    public function getDashboardStats(): array
    {
        $db = \Config\Database::connect();
        $totalMeetings = $this->countAllResults();
        $activeMeetings = $this->whereIn('status', ['draft', 'ongoing'])->countAllResults();
        $completedMeetings = $this->where('status', 'completed')->countAllResults();
        $archivedMeetings = $this->where('status', 'archived')->countAllResults();

        $totalAttendees = $db->table('attendances')->countAllResults();
        $totalPhotos = $db->table('meeting_documentations')->countAllResults();

        $thisMonthMeetings = $this->where('meeting_date >=', date('Y-m-01'))
                                  ->where('meeting_date <=', date('Y-m-t'))
                                  ->countAllResults();

        return [
            'total_meetings'       => $totalMeetings,
            'active_meetings'      => $activeMeetings,
            'completed_meetings'   => $completedMeetings,
            'archived_meetings'    => $archivedMeetings,
            'total_attendees'      => $totalAttendees,
            'total_photos'         => $totalPhotos,
            'this_month_meetings'  => $thisMonthMeetings,
        ];
    }
}

