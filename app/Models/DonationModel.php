<?php

namespace App\Models;

use CodeIgniter\Model;

class DonationModel extends Model
{
    protected $table = 'donations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['lead_id', 'amount', 'payment_method', 'status'];
    protected $useTimestamps = false;
}
