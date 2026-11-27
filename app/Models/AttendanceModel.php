<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table            = 'attendances';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'meeting_id',
        'participant_name',
        'institution',
        'phone',
        'email',
        'attendance_status',
        'check_in_time',
        'signature_image',
        'notes',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get attendance list for a meeting
     */
    public function getByMeeting(int $meetingId, ?string $search = null)
    {
        $query = $this->where('meeting_id', $meetingId);
        if (!empty($search)) {
            $query->groupStart()
                  ->like('participant_name', $search)
                  ->orLike('institution', $search)
                  ->orLike('phone', $search)
                  ->groupEnd();
        }
        return $query->orderBy('check_in_time', 'DESC')->findAll();
    }

    /**
     * Save digital signature from base64 string
     */
    public function storeSignature(string $base64Data, string $prefix = 'sig'): ?string
    {
        if (empty($base64Data) || strpos($base64Data, 'data:image') === false) {
            return null;
        }

        $sigDir = FCPATH . 'uploads/signatures';
        if (!is_dir($sigDir)) {
            mkdir($sigDir, 0777, true);
        }

        // Clean base64
        $cleanData = preg_replace('#^data:image/\w+;base64,#i', '', $base64Data);
        $cleanData = str_replace(' ', '+', $cleanData);
        $decoded = base64_decode($cleanData);

        if (!$decoded) {
            return null;
        }

        $filename = $prefix . '_' . time() . '_' . mt_rand(1000, 9999) . '.png';
        $fullPath = $sigDir . '/' . $filename;
        file_put_contents($fullPath, $decoded);

        return 'uploads/signatures/' . $filename;
    }
}

