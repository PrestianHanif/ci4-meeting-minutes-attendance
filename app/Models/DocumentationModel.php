<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentationModel extends Model
{
    protected $table            = 'meeting_documentations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'meeting_id',
        'file_path',
        'caption',
        'taken_at',
        'display_order',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getByMeeting(int $meetingId)
    {
        return $this->where('meeting_id', $meetingId)
                    ->orderBy('display_order', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }
}

