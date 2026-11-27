<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table            = 'admins';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'password_hash',
        'full_name',
        'role',
        'email',
        'phone',
        'last_login',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Authenticate admin by username and password
     */
    public function authenticate(string $username, string $password): ?array
    {
        $admin = $this->where('username', trim($username))->first();
        if (!$admin) {
            return null;
        }

        if (!password_verify($password, $admin['password_hash'])) {
            return null;
        }

        // Update last login
        $this->update($admin['id'], ['last_login' => date('Y-m-d H:i:s')]);

        return $admin;
    }
}
