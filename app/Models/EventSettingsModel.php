<?php

namespace App\Models;

use CodeIgniter\Model;

class EventSettingsModel extends Model
{
    protected $table            = 'event_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'candidate_name',
        'candidate_nim',
        'dissertation_title',
        'event_day_date',
        'event_hijri_date',
        'event_time',
        'event_room',
        'signatory_title',
        'signatory_name',
        'is_event_completed',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = '';
    protected $updatedField  = 'updated_at';

    /**
     * Get or initialize default event settings
     */
    public function getSettings(): array
    {
        $settings = $this->first();
        if (!$settings) {
            $default = [
                'candidate_name'     => 'Muhammad Abu Rivai, S.H., M.H.',
                'candidate_nim'      => '21933020 (HI)',
                'dissertation_title' => 'DINAMIKA PERENCANAAN WARIS DALAM MITIGASI SENGKETA PADA MASYARAKAT JAWA MUSLIM',
                'event_day_date'     => 'Selasa, 20 Oktober 2026',
                'event_hijri_date'   => 'Selasa, 9 Jumadil Awal 1448 H',
                'event_time'         => '09.00 - 11.00 WIB',
                'event_room'         => 'Ruang 03.16 Gedung K.H. A. Wahid Hasyim, Kampus Terpadu Universitas Islam Indonesia, Jl. Kaliurang KM. 14,5 Sleman Yogyakarta 55584',
                'signatory_title'    => 'Dekan FIAI UII',
                'signatory_name'     => 'Dr. Drs. Asmuni, M.A.',
                'is_event_completed' => 1,
            ];
            $id = $this->insert($default, true);
            $default['id'] = $id;
            return $default;
        }

        // Pastikan key is_event_completed selalu ada dengan nilai default 1 (selesai)
        if (!isset($settings['is_event_completed'])) {
            $settings['is_event_completed'] = 1;
        }

        return $settings;
    }
}
