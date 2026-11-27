<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\SettingModel;

class AuthController extends BaseController
{
    protected AdminModel $adminModel;
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->settingModel = new SettingModel();
    }

    /**
     * Halaman Login Pengurus / Admin KOWPI
     */
    public function login()
    {
        if (session()->get('is_admin_logged_in') || session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }

        $settings = $this->settingModel->getSettings();

        $data = [
            'title'    => 'Masuk Sistem Notula & Presensi - ' . ($settings['org_short'] ?? 'KOWPI'),
            'settings' => $settings,
        ];

        return view('auth/login', $data);
    }

    /**
     * Proses Submit Login
     */
    public function submitLogin()
    {
        $username = trim($this->request->getPost('username') ?? '');
        $password = trim($this->request->getPost('password') ?? '');

        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Username dan kata sandi wajib diisi.');
        }

        $admin = $this->adminModel->authenticate($username, $password);

        if (!$admin) {
            return redirect()->back()->withInput()->with('error', 'Username atau kata sandi tidak sesuai.');
        }

        // Set session data
        $sessionData = [
            'is_admin_logged_in' => true,
            'isLoggedIn'         => true,
            'admin_id'           => $admin['id'],
            'admin_username'     => $admin['username'],
            'admin_name'         => $admin['full_name'],
            'admin_role'         => $admin['role'],
            'logged_at'          => date('Y-m-d H:i:s'),
        ];
        session()->set($sessionData);

        $intended = session()->get('intended_url');
        if (!empty($intended)) {
            session()->remove('intended_url');
            return redirect()->to($intended);
        }

        return redirect()->to(base_url('dashboard'))->with('success', 'Selamat datang kembali, ' . $admin['full_name'] . '!');
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
