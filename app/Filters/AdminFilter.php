<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->get('is_admin_logged_in') && !$session->get('isLoggedIn')) {
            // Simpan URL tujuan agar setelah login langsung kembali ke halaman tersebut
            $session->set('intended_url', current_url());
            return redirect()->to(base_url('login'))->with('error', 'Silakan masuk dengan akun Panitia/Admin terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
