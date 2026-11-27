<?php

namespace App\Controllers;

use App\Models\AdminUserModel;

class AdminAuth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }
        return view('admin/login');
    }

    public function loginSubmit()
    {
        $session = session();
        $model = new AdminUserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $user = $model->where('username', $username)->first();
        
        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                $sessionData = [
                    'admin_id' => $user['id'],
                    'username' => $user['username'],
                    'isLoggedIn' => true
                ];
                $session->set($sessionData);
                return redirect()->to('/admin');
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->to('/admin/login')->withInput();
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->to('/admin/login')->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}
