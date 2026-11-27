<?php

namespace App\Models;

use CodeIgniter\Model;

class MeetingMinutesModel extends Model
{
    protected $table            = 'meeting_minutes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'meeting_id',
        'opening_notes',
        'discussion',
        'decisions',
        'action_items',
        'closing_notes',
        'leader_signature',
        'notary_signature',
        'is_signed_leader',
        'is_signed_notary',
        'include_stamp',
        'pdf_path',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get or initialize minutes for a meeting
     */
    public function getOrInit(int $meetingId): array
    {
        $minutes = $this->where('meeting_id', $meetingId)->first();
        if (!$minutes) {
            $data = [
                'meeting_id'       => $meetingId,
                'opening_notes'    => '',
                'discussion'       => '',
                'decisions'        => '',
                'action_items'     => '[]',
                'closing_notes'    => '',
                'is_signed_leader' => 0,
                'is_signed_notary' => 0,
                'include_stamp'    => 1,
            ];
            $id = $this->insert($data, true);
            return $this->find($id);
        }
        return $minutes;
    }
}

