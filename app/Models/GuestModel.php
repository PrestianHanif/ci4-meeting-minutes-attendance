<?php

namespace App\Models;

use CodeIgniter\Model;

class GuestModel extends Model
{
    protected $table            = 'guests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'guest_code',
        'salutation',
        'full_name',
        'institution',
        'phone',
        'guest_type',
        'pdf_filename',
        'is_present',
        'check_in_time',
        'signature_image',
        'wishes',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get real-time attendance stats
     */
    public function getStats(): array
    {
        $total = (new static())->countAllResults();
        $present = (new static())->where('is_present', 1)->countAllResults();
        $invited = (new static())->where('guest_type', 'invited')->countAllResults();
        $walkIn = (new static())->where('guest_type', 'walk_in')->countAllResults();
        $presentInvited = (new static())->where('guest_type', 'invited')->where('is_present', 1)->countAllResults();
        $presentWalkIn = (new static())->where('guest_type', 'walk_in')->where('is_present', 1)->countAllResults();

        $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

        return [
            'total'           => $total,
            'present'         => $present,
            'absent'          => max(0, $total - $present),
            'invited'         => $invited,
            'walk_in'         => $walkIn,
            'present_invited' => $presentInvited,
            'present_walk_in' => $presentWalkIn,
            'percentage'      => $percentage,
        ];
    }

    /**
     * Generate next guest code for walk-in guests
     */
    public function getNextWalkInCode(): string
    {
        $last = $this->where('guest_type', 'walk_in')
                     ->orderBy('id', 'DESC')
                     ->first();
        if ($last && preg_match('/WALKIN-(\d+)/', $last['guest_code'], $m)) {
            $next = ((int)$m[1]) + 1;
        } else {
            $next = 1;
        }
        return sprintf("WALKIN-%03d", $next);
    }

    /**
     * Generate next guest code for invited guests
     */
    public function getNextInvitedCode(): string
    {
        $last = $this->where('guest_type', 'invited')
                     ->orderBy('id', 'DESC')
                     ->first();
        if ($last && preg_match('/KOWPI-(\d+)/', $last['guest_code'], $m)) {
            $next = ((int)$m[1]) + 1;
        } else {
            $next = 1;
        }
        return sprintf("KOWPI-%03d", $next);
    }

    /**
     * Filter guests
     */
    public function filterGuests(?string $search = null, ?string $status = null, ?string $type = null, ?string $institution = null)
    {
        $builder = $this;

        if (!empty($search)) {
            $builder = $builder->groupStart()
                               ->like('full_name', $search)
                               ->orLike('institution', $search)
                               ->orLike('guest_code', $search)
                               ->orLike('phone', $search)
                               ->groupEnd();
        }

        if (!empty($institution)) {
            $builder = $builder->where('institution', $institution);
        }

        if ($status === 'present') {
            $builder = $builder->where('is_present', 1);
        } elseif ($status === 'absent') {
            $builder = $builder->where('is_present', 0);
        }

        if ($type === 'invited') {
            $builder = $builder->where('guest_type', 'invited');
        } elseif ($type === 'walk_in') {
            $builder = $builder->where('guest_type', 'walk_in');
        }

        return $builder;
    }

    /**
     * Get distinct institutions with guest count
     */
    public function getInstitutionsList(): array
    {
        return $this->select('institution, count(*) as total_guests')
                    ->where('institution !=', '')
                    ->where('institution IS NOT NULL')
                    ->groupBy('institution')
                    ->orderBy('total_guests', 'DESC')
                    ->orderBy('institution', 'ASC')
                    ->findAll();
    }
}
