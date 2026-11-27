<?php

namespace App\Models;

use CodeIgniter\Model;

class LeadModel extends Model
{
    protected $table            = 'leads';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_lengkap', 'email', 'nomor_whatsapp', 'rentang_umur', 'tanggal_lahir', 'status_pekerjaan', 'consent_given'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nama_lengkap'     => 'required|min_length[3]|max_length[150]',
        'email'            => 'required|valid_email|max_length[150]',
        'nomor_whatsapp'   => 'required|numeric|max_length[25]',
        'rentang_umur'     => 'permit_empty|max_length[50]',
        'tanggal_lahir'    => 'permit_empty|max_length[50]',
        'status_pekerjaan' => 'permit_empty|max_length[100]',
        'consent_given'    => 'required|in_list[1,on,true]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
