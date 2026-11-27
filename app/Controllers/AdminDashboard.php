<?php

namespace App\Controllers;

use App\Models\LeadModel;
use App\Models\VisitorModel;
use App\Models\DonationModel;

class AdminDashboard extends BaseController
{
    public function index()
    {
        $leadModel = new LeadModel();
        $visitorModel = new VisitorModel();
        $donationModel = new DonationModel();

        $data['leads'] = $leadModel->orderBy('COALESCE(updated_at, created_at)', 'DESC', false)->findAll();
        
        $today = date('Y-m-d');
        
        $data['total_leads'] = $leadModel->countAllResults();
        $data['leads_today'] = $leadModel->where('DATE(created_at)', $today)->countAllResults();
        $data['total_visitors'] = $visitorModel->countAllResults();
        $data['visitors_today'] = $visitorModel->where('visit_date', $today)->countAllResults();

        // Donations data
        $data['donations'] = $donationModel->select('donations.*, leads.nama_lengkap, leads.nomor_whatsapp, leads.email')
                                           ->join('leads', 'leads.id = donations.lead_id', 'left')
                                           ->orderBy('donations.created_at', 'DESC')
                                           ->findAll();
                                           
        $data['total_donations'] = $donationModel->selectSum('amount')->first()['amount'] ?? 0;
        $data['total_donations_success'] = $donationModel->where('status', 'success')->selectSum('amount')->first()['amount'] ?? 0;
        $data['count_donations_pending'] = $donationModel->where('status', 'pending')->countAllResults();
        $data['count_donations_success'] = $donationModel->where('status', 'success')->countAllResults();
        $data['count_donations_cancelled'] = $donationModel->where('status', 'cancelled')->countAllResults();

        // Ebook file information
        $pdfPath = FCPATH . 'downloads' . DIRECTORY_SEPARATOR . 'panduan-fikih-harta-anak-yatim.pdf';
        $metaPath = WRITEPATH . 'ebook_meta.json';
        $displayTitle = 'panduan-fikih-harta-anak-yatim.pdf';
        if (file_exists($metaPath)) {
            $metaData = json_decode(file_get_contents($metaPath), true);
            if (!empty($metaData['title'])) {
                $displayTitle = $metaData['title'];
            } elseif (!empty($metaData['original_name'])) {
                $displayTitle = $metaData['original_name'];
            }
        }

        if (file_exists($pdfPath)) {
            $bytes = filesize($pdfPath);
            $sizeStr = $bytes >= 1048576 
                ? number_format($bytes / 1048576, 2) . ' MB' 
                : number_format($bytes / 1024, 1) . ' KB';

            $modTime = filemtime($pdfPath);
            $tz = new \DateTimeZone('Asia/Jakarta');
            $dt = new \DateTime();
            $dt->setTimestamp($modTime);
            $dt->setTimezone($tz);

            $data['ebook_info'] = [
                'exists'       => true,
                'filename'     => $displayTitle,
                'system_name'  => 'panduan-fikih-harta-anak-yatim.pdf',
                'size'         => $sizeStr,
                'filesize'     => $sizeStr,
                'bytes'        => $bytes,
                'updated_at'   => $dt->format('d M Y, H:i') . ' WIB',
                'url'          => base_url('downloads/panduan-fikih-harta-anak-yatim.pdf') . '?v=' . $modTime,
                'download_url' => site_url('admin/download-ebook')
            ];
        } else {
            $data['ebook_info'] = [
                'exists'       => false,
                'filename'     => 'Belum diunggah',
                'system_name'  => 'panduan-fikih-harta-anak-yatim.pdf',
                'size'         => '-',
                'filesize'     => '-',
                'bytes'        => 0,
                'updated_at'   => '-',
                'url'          => '#',
                'download_url' => '#'
            ];
        }

        return view('admin/dashboard', $data);
    }

    public function exportExcel()
    {
        $leadModel = new LeadModel();
        $leads = $leadModel->orderBy('COALESCE(updated_at, created_at)', 'DESC', false)->findAll();

        $filename = 'Export_Leads_' . date('Ymd_His') . '.xls';

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "\xEF\xBB\xBF"; // UTF-8 BOM for Microsoft Excel
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            table { border-collapse: collapse; width: 100%; font-family: Calibri, Arial, sans-serif; font-size: 11pt; }
            th { background-color: #059669; color: #ffffff; font-weight: bold; border: 1px solid #047857; padding: 10px 8px; text-align: left; }
            td { border: 1px solid #d1d5db; padding: 8px; vertical-align: middle; }
            .num-col { text-align: center; }
            .text-col { mso-number-format:"\@"; }
        </style>
        <table border="1">
            <thead>
                <tr>
                    <th class="num-col" style="width: 45px;">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. WhatsApp</th>
                    <th>Rentang Umur</th>
                    <th>Status Pekerjaan</th>
                    <th>Waktu Mendaftar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leads as $i => $lead): 
                    $nama = $lead['nama_lengkap'] ?? '-';
                    if (!empty($nama) && in_array($nama[0], ['=', '+', '-', '@'])) {
                        $nama = "'" . $nama;
                    }
                    $umur = $lead['rentang_umur'] ?? ($lead['tanggal_lahir'] ? date('d/m/Y', strtotime($lead['tanggal_lahir'])) : '-');
                    $waktu = date('d/m/Y H:i', strtotime($lead['created_at']));
                ?>
                <tr>
                    <td class="num-col"><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($nama) ?></td>
                    <td><?= htmlspecialchars($lead['email'] ?? '-') ?></td>
                    <td class="text-col"><?= htmlspecialchars($lead['nomor_whatsapp'] ?? '-') ?></td>
                    <td class="text-col"><?= htmlspecialchars($umur) ?></td>
                    <td><?= htmlspecialchars($lead['status_pekerjaan'] ?? '-') ?></td>
                    <td class="text-col"><?= $waktu ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        exit;
    }

    public function exportLeads()
    {
        return $this->exportExcel();
    }

    public function exportDonations()
    {
        $donationModel = new DonationModel();
        $donations = $donationModel->select('donations.*, leads.nama_lengkap, leads.email, leads.nomor_whatsapp')
                                   ->join('leads', 'leads.id = donations.lead_id', 'left')
                                   ->orderBy('donations.created_at', 'DESC')
                                   ->findAll();

        $filename = 'Export_Donasi_' . date('Ymd_His') . '.xls';

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "\xEF\xBB\xBF"; // UTF-8 BOM for Microsoft Excel
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            table { border-collapse: collapse; width: 100%; font-family: Calibri, Arial, sans-serif; font-size: 11pt; }
            th { background-color: #d97706; color: #ffffff; font-weight: bold; border: 1px solid #b45309; padding: 10px 8px; text-align: left; }
            td { border: 1px solid #d1d5db; padding: 8px; vertical-align: middle; }
            .num-col { text-align: center; }
            .text-col { mso-number-format:"\@"; }
            .currency-col { text-align: right; mso-number-format:"\#\,\#\#0"; }
            .badge-success { background-color: #d1fae5; color: #065f46; font-weight: bold; text-align: center; }
            .badge-pending { background-color: #fef3c7; color: #92400e; font-weight: bold; text-align: center; }
            .badge-cancelled { background-color: #f1f5f9; color: #64748b; font-weight: bold; text-align: center; }
        </style>
        <table border="1">
            <thead>
                <tr>
                    <th class="num-col" style="width: 45px;">No</th>
                    <th>Nama Donatur</th>
                    <th>Email</th>
                    <th>No. WhatsApp</th>
                    <th style="text-align: right;">Nominal Donasi (Rp)</th>
                    <th>Metode Pembayaran</th>
                    <th style="text-align: center;">Status</th>
                    <th>Waktu Donasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donations as $i => $don): 
                    $nama = $don['nama_lengkap'] ?? 'Anonim';
                    if (!empty($nama) && in_array($nama[0], ['=', '+', '-', '@'])) {
                        $nama = "'" . $nama;
                    }
                    $status = $don['status'] ?? 'pending';
                    $statusClass = ($status === 'success') ? 'badge-success' : (($status === 'cancelled') ? 'badge-cancelled' : 'badge-pending');
                    $statusText = ($status === 'success') ? 'Berhasil' : (($status === 'cancelled') ? 'Dibatalkan' : 'Menunggu');
                    $waktu = date('d/m/Y H:i', strtotime($don['created_at']));
                ?>
                <tr>
                    <td class="num-col"><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($nama) ?></td>
                    <td><?= htmlspecialchars($don['email'] ?? '-') ?></td>
                    <td class="text-col"><?= htmlspecialchars($don['nomor_whatsapp'] ?? '-') ?></td>
                    <td class="currency-col"><?= number_format($don['amount'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars(strtoupper($don['payment_method'] ?? '-')) ?></td>
                    <td class="<?= $statusClass ?>"><?= $statusText ?></td>
                    <td class="text-col"><?= $waktu ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        exit;
    }

    public function uploadEbook()
    {
        $validationRule = [
            'ebook_file' => [
                'label' => 'File Ebook PDF',
                'rules' => [
                    'uploaded[ebook_file]',
                    'ext_in[ebook_file,pdf,PDF]',
                    'max_size[ebook_file,30720]', // 30MB max
                ],
                'errors' => [
                    'uploaded' => 'Silakan pilih file PDF terlebih dahulu.',
                    'ext_in'   => 'Format file harus berupa dokumen PDF (.pdf).',
                    'max_size' => 'Ukuran file PDF maksimal adalah 30MB.'
                ]
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->to(site_url('admin#sectionEbook'))->with('error', $this->validator->getError('ebook_file'));
        }

        $file = $this->request->getFile('ebook_file');

        if (!$file || !$file->isValid()) {
            $errorMsg = $file ? $file->getErrorString() : 'File upload tidak terdeteksi.';
            return redirect()->to(site_url('admin#sectionEbook'))->with('error', 'Gagal upload: ' . $errorMsg);
        }

        if (!$file->hasMoved()) {
            $uploadPath = FCPATH . 'downloads' . DIRECTORY_SEPARATOR;
            if (!is_dir($uploadPath)) {
                @mkdir($uploadPath, 0777, true);
            }

            $targetMain = $uploadPath . 'panduan-fikih-harta-anak-yatim.pdf';
            $targetAlias = $uploadPath . 'ebook.pdf';

            // Remove existing if any
            if (file_exists($targetMain)) {
                @unlink($targetMain);
            }
            if (file_exists($targetAlias)) {
                @unlink($targetAlias);
            }

            // Move to target
            $clientName = $file->getClientName();

            $file->move($uploadPath, 'panduan-fikih-harta-anak-yatim.pdf');
            @copy($targetMain, $targetAlias);

            // Save meta automatically from uploaded file name
            $meta = [
                'title'         => $clientName,
                'original_name' => $clientName,
                'uploaded_at'   => date('Y-m-d H:i:s'),
            ];
            file_put_contents(WRITEPATH . 'ebook_meta.json', json_encode($meta, JSON_PRETTY_PRINT));

            return redirect()->to(site_url('admin#sectionEbook'))->with('success', 'Alhamdulillah, file Ebook PDF "' . esc($clientName) . '" berhasil diperbarui!');
        }

        return redirect()->to(site_url('admin#sectionEbook'))->with('error', 'Terjadi kesalahan saat memindahkan file.');
    }

    public function updateTitle()
    {
        $newTitle = trim($this->request->getPost('ebook_title') ?? '');
        if (!empty($newTitle)) {
            $metaPath = WRITEPATH . 'ebook_meta.json';
            $meta = file_exists($metaPath) ? json_decode(file_get_contents($metaPath), true) : [];
            $meta['title'] = $newTitle;
            $meta['updated_at'] = date('Y-m-d H:i:s');
            file_put_contents($metaPath, json_encode($meta, JSON_PRETTY_PRINT));

            return redirect()->to(site_url('admin#sectionEbook'))->with('success', 'Judul tampilan ebook berhasil diperbarui menjadi "' . esc($newTitle) . '"!');
        }
        return redirect()->to(site_url('admin#sectionEbook'))->with('error', 'Judul ebook tidak boleh kosong.');
    }

    public function downloadEbook()
    {
        $pdfPath = FCPATH . 'downloads' . DIRECTORY_SEPARATOR . 'panduan-fikih-harta-anak-yatim.pdf';
        if (file_exists($pdfPath)) {
            $metaPath = WRITEPATH . 'ebook_meta.json';
            $downloadName = 'panduan-fikih-harta-anak-yatim.pdf';
            if (file_exists($metaPath)) {
                $meta = json_decode(file_get_contents($metaPath), true);
                if (!empty($meta['title'])) {
                    $downloadName = $meta['title'];
                    if (!str_ends_with(strtolower($downloadName), '.pdf')) {
                        $downloadName .= '.pdf';
                    }
                }
            }
            return $this->response->download($pdfPath, null)->setFileName($downloadName);
        }
        return redirect()->to(site_url('admin#sectionEbook'))->with('error', 'File PDF belum tersedia untuk diunduh.');
    }

    public function updateDonationStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        $allowedStatuses = ['pending', 'success', 'cancelled'];
        if (!$id || !in_array($status, $allowedStatuses, true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Status atau ID donasi tidak valid.'
            ]);
        }

        $donationModel = new DonationModel();
        $donation = $donationModel->find($id);

        if (!$donation) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Data donasi tidak ditemukan.'
            ]);
        }

        $donationModel->update($id, ['status' => $status]);

        // Recalculate stats for live UI update
        $totalAll = (float)($donationModel->selectSum('amount')->first()['amount'] ?? 0);
        $totalSuccess = (float)($donationModel->where('status', 'success')->selectSum('amount')->first()['amount'] ?? 0);
        $countPending = $donationModel->where('status', 'pending')->countAllResults();
        $countSuccess = $donationModel->where('status', 'success')->countAllResults();
        $countCancelled = $donationModel->where('status', 'cancelled')->countAllResults();

        $statusLabels = [
            'pending'   => 'Menunggu',
            'success'   => 'Berhasil',
            'cancelled' => 'Dibatalkan'
        ];

        return $this->response->setJSON([
            'success'       => true,
            'message'       => 'Status donasi berhasil diubah menjadi "' . ($statusLabels[$status] ?? $status) . '".',
            'new_status'    => $status,
            'status_label'  => $statusLabels[$status] ?? $status,
            'stats'         => [
                'total_all'             => $totalAll,
                'total_all_fmt'         => number_format($totalAll, 0, ',', '.'),
                'total_success'         => $totalSuccess,
                'total_success_fmt'     => number_format($totalSuccess, 0, ',', '.'),
                'count_pending'         => $countPending,
                'count_success'         => $countSuccess,
                'count_cancelled'       => $countCancelled,
            ]
        ]);
    }

    public function deleteLead()
    {
        $id = $this->request->getPost('id');

        if (!$id || !is_numeric($id)) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'ID lead tidak valid.'
                ]);
            }
            return redirect()->to(site_url('admin#sectionLeads'))->with('error', 'ID lead tidak valid.');
        }

        $leadModel = new LeadModel();
        $lead = $leadModel->find($id);

        if (!$lead) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(404)->setJSON([
                    'success' => false,
                    'message' => 'Data leads tidak ditemukan atau sudah dihapus sebelumnya.'
                ]);
            }
            return redirect()->to(site_url('admin#sectionLeads'))->with('error', 'Data leads tidak ditemukan.');
        }

        $leadName = $lead['nama_lengkap'] ?? 'Pendaftar';

        // Hapus donasi terkait jika ada (menjaga integritas data)
        $donationModel = new DonationModel();
        $donationModel->where('lead_id', $id)->delete();

        // Hapus data lead
        $leadModel->delete($id);

        // Hitung ulang statistik untuk live update tanpa reload
        $today = date('Y-m-d');
        $totalLeads = $leadModel->countAllResults();
        $leadsToday = $leadModel->where('DATE(created_at)', $today)->countAllResults();

        // Recalculate donation stats in case related donations were also deleted
        $totalDonations = (float)($donationModel->selectSum('amount')->first()['amount'] ?? 0);
        $totalDonationsSuccess = (float)($donationModel->where('status', 'success')->selectSum('amount')->first()['amount'] ?? 0);
        $countPending = $donationModel->where('status', 'pending')->countAllResults();
        $countSuccess = $donationModel->where('status', 'success')->countAllResults();
        $countCancelled = $donationModel->where('status', 'cancelled')->countAllResults();
        $totalDonationsCount = $donationModel->countAllResults();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success'   => true,
                'message'   => 'Data leads "' . $leadName . '" berhasil dihapus.',
                'lead_id'   => (int)$id,
                'lead_name' => $leadName,
                'stats'     => [
                    'total_leads'                 => $totalLeads,
                    'total_leads_fmt'             => number_format($totalLeads),
                    'leads_today'                 => $leadsToday,
                    'leads_today_fmt'             => number_format($leadsToday),
                    'total_donations'             => $totalDonations,
                    'total_donations_fmt'         => number_format($totalDonations, 0, ',', '.'),
                    'total_donations_success'     => $totalDonationsSuccess,
                    'total_donations_success_fmt' => number_format($totalDonationsSuccess, 0, ',', '.'),
                    'count_donations_pending'     => $countPending,
                    'count_donations_success'     => $countSuccess,
                    'count_donations_cancelled'   => $countCancelled,
                    'total_donations_count'       => $totalDonationsCount,
                ]
            ]);
        }

        return redirect()->to(site_url('admin#sectionLeads'))->with('success', 'Data leads "' . $leadName . '" berhasil dihapus.');
    }
}

