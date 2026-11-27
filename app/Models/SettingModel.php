<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'org_name',
        'org_short',
        'org_tagline',
        'org_address',
        'org_website',
        'org_email',
        'org_phone',
        'org_logo',
        'org_stamp',
        'default_pimpinan',
        'default_pimpinan_title',
        'default_notulis',
        'default_notulis_title',
    ];

    protected $useTimestamps = true;
    protected $createdField  = '';
    protected $updatedField  = 'updated_at';

    /**
     * Get single global setting row (id = 1)
     */
    public function getSettings(): array
    {
        $settings = $this->first();
        if (!$settings) {
            $default = [
                'org_name'               => 'Komunitas Waris Planning Indonesia (KOWPI)',
                'org_short'              => 'KOWPI',
                'org_tagline'            => 'Menata kehidupan dengan baik, mempersiapkan akhir yang mulia.',
                'org_address'            => 'Jl. Nangka 1 No.154 Karangnongko, Maguwoharjo, Depok, Sleman',
                'org_website'            => 'https://kowpi.id',
                'org_email'              => 'sekretariat@kowpi.id',
                'org_phone'              => '0812-0000-0000',
                'org_logo'               => 'assets/img/logo-kowpi-coklat.png',
                'org_stamp'              => 'assets/img/stempel-kowpi-transparan.png',
                'default_pimpinan'       => 'Dr. Drs. Asmuni, M.A.',
                'default_pimpinan_title' => 'Ketua Dewan Pembina KOWPI',
                'default_notulis'        => 'Ust. Muhammad Abu Rivai, S.H.I., M.H.',
                'default_notulis_title'  => 'Sekretaris Eksekutif KOWPI',
            ];
            $this->insert($default);
            return $this->first();
        }
        return $settings;
    }
}

