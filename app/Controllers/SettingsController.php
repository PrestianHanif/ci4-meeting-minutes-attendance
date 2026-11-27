<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class SettingsController extends BaseController
{
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    /**
     * Tampilan Pengaturan Lembaga KOWPI
     */
    public function index()
    {
        $settings = $this->settingModel->getSettings();

        $data = [
            'title'     => 'Pengaturan Organisasi & Surat KOWPI',
            'activeNav' => 'settings',
            'settings'  => $settings,
        ];

        return view('settings/index', $data);
    }

    /**
     * Update Pengaturan
     */
    public function update()
    {
        $settings = $this->settingModel->getSettings();

        $updateData = [
            'org_name'               => trim($this->request->getPost('org_name') ?? $settings['org_name']),
            'org_short'              => trim($this->request->getPost('org_short') ?? $settings['org_short']),
            'org_tagline'            => trim($this->request->getPost('org_tagline') ?? $settings['org_tagline']),
            'org_address'            => trim($this->request->getPost('org_address') ?? $settings['org_address']),
            'org_website'            => trim($this->request->getPost('org_website') ?? $settings['org_website']),
            'org_email'              => trim($this->request->getPost('org_email') ?? $settings['org_email']),
            'org_phone'              => trim($this->request->getPost('org_phone') ?? $settings['org_phone']),
            'default_pimpinan'       => trim($this->request->getPost('default_pimpinan') ?? $settings['default_pimpinan']),
            'default_pimpinan_title' => trim($this->request->getPost('default_pimpinan_title') ?? $settings['default_pimpinan_title']),
            'default_notulis'        => trim($this->request->getPost('default_notulis') ?? $settings['default_notulis']),
            'default_notulis_title'  => trim($this->request->getPost('default_notulis_title') ?? $settings['default_notulis_title']),
        ];

        $files = $this->request->getFiles();

        // Logo upload
        if (isset($files['org_logo']) && $files['org_logo']->isValid() && !$files['org_logo']->hasMoved()) {
            $ext = $files['org_logo']->getClientExtension();
            if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'svg'])) {
                $newName = 'logo_' . time() . '.' . $ext;
                $files['org_logo']->move(FCPATH . 'uploads', $newName);
                $updateData['org_logo'] = 'uploads/' . $newName;
            }
        }

        // Stamp upload
        if (isset($files['org_stamp']) && $files['org_stamp']->isValid() && !$files['org_stamp']->hasMoved()) {
            $ext = $files['org_stamp']->getClientExtension();
            if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'svg'])) {
                $newName = 'stamp_' . time() . '.' . $ext;
                $files['org_stamp']->move(FCPATH . 'uploads', $newName);
                $updateData['org_stamp'] = 'uploads/' . $newName;
            }
        }

        $this->settingModel->update($settings['id'], $updateData);

        return redirect()->to(base_url('pengaturan'))->with('success', 'Pengaturan organisasi KOWPI berhasil diperbarui.');
    }
}
