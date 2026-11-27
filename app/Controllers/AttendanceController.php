<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MeetingModel;
use App\Models\AttendanceModel;
use App\Models\SettingModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AttendanceController extends BaseController
{
    protected MeetingModel $meetingModel;
    protected AttendanceModel $attendanceModel;
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->meetingModel    = new MeetingModel();
        $this->attendanceModel = new AttendanceModel();
        $this->settingModel    = new SettingModel();
    }

    /**
     * Resolves meeting by code or ID. Defaults to newest ongoing meeting if null.
     */
    protected function resolveMeeting($identifier = null): ?array
    {
        if (empty($identifier)) {
            $meeting = $this->meetingModel
                ->whereIn('status', ['ongoing', 'draft'])
                ->orderBy('meeting_date', 'DESC')
                ->orderBy('id', 'DESC')
                ->first();
            if (!$meeting) {
                $meeting = $this->meetingModel->orderBy('id', 'DESC')->first();
            }
            return $meeting;
        }

        if (is_numeric($identifier)) {
            return $this->meetingModel->find((int)$identifier);
        }

        return $this->meetingModel->where('meeting_code', $identifier)->first();
    }

    /**
     * Halaman Kiosk / Tablet Presensi Rapat (Publik & Touch Friendly)
     */
    public function kiosk($identifier = null)
    {
        $meeting = $this->resolveMeeting($identifier);
        $settings = $this->settingModel->getSettings();

        if (!$meeting) {
            return view('attendance/not_found', [
                'title'    => 'Rapat Tidak Ditemukan',
                'settings' => $settings,
            ]);
        }

        $attendances = $this->attendanceModel->getByMeeting($meeting['id']);

        $data = [
            'title'       => 'Presensi Digital: ' . $meeting['title'],
            'meeting'     => $meeting,
            'attendances' => $attendances,
            'settings'    => $settings,
        ];

        return view('attendance/kiosk', $data);
    }

    /**
     * AJAX Submit Presensi Kehadiran & TTD Digital
     */
    public function submitAttendance()
    {
        $meetingId = (int)$this->request->getPost('meeting_id');
        $meeting   = $this->meetingModel->find($meetingId);

        if (!$meeting) {
            return $this->response->setJSON(['success' => false, 'message' => 'Rapat tidak valid.'])->setStatusCode(404);
        }

        if (empty($meeting['is_presence_open']) || $meeting['status'] === 'archived') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Presensi untuk rapat ini telah resmi dikunci atau ditutup oleh pimpinan.'
            ])->setStatusCode(403);
        }

        $name   = trim($this->request->getPost('participant_name') ?? '');
        $inst   = trim($this->request->getPost('institution') ?? '');
        $phone  = trim($this->request->getPost('phone') ?? '');
        $email  = trim($this->request->getPost('email') ?? '');
        $status = trim($this->request->getPost('attendance_status') ?? 'hadir_offline');
        $notes  = trim($this->request->getPost('notes') ?? '');
        $sigData = $this->request->getPost('signature_data');

        if (empty($name)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Nama lengkap wajib diisi.'])->setStatusCode(422);
        }

        // Simpan TTD digital
        $sigPath = null;
        if (!empty($sigData)) {
            $prefix = 'sig_' . preg_replace('/[^a-zA-Z0-9]/', '', substr($name, 0, 8));
            $sigPath = $this->attendanceModel->storeSignature($sigData, $prefix);
        }

        $insertData = [
            'meeting_id'        => $meetingId,
            'participant_name'  => $name,
            'institution'       => !empty($inst) ? $inst : 'Pengurus / Anggota KOWPI',
            'phone'             => $phone,
            'email'             => $email,
            'attendance_status' => $status,
            'check_in_time'     => date('Y-m-d H:i:s'),
            'signature_image'   => $sigPath,
            'notes'             => $notes,
        ];

        $attId = $this->attendanceModel->insert($insertData, true);
        $saved = $this->attendanceModel->find($attId);

        // Hitung total hadir terkini
        $totalPresent = $this->attendanceModel
            ->where('meeting_id', $meetingId)
            ->whereIn('attendance_status', ['hadir_offline', 'hadir_online'])
            ->countAllResults();

        return $this->response->setJSON([
            'success'       => true,
            'message'       => "Alhamdulillah, kehadiran {$name} berhasil dicatat!",
            'data'          => $saved,
            'total_present' => $totalPresent,
        ]);
    }

    /**
     * Tampilan Live Board Kehadiran untuk Proyektor / Layar TV Rapat
     */
    public function liveBoard($identifier)
    {
        $meeting = $this->resolveMeeting($identifier);
        $settings = $this->settingModel->getSettings();

        if (!$meeting) {
            return redirect()->to(base_url('presensi'))->with('error', 'Rapat tidak ditemukan.');
        }

        $attendances = $this->attendanceModel->getByMeeting($meeting['id']);

        $data = [
            'title'       => 'Live Board Kehadiran - ' . $meeting['title'],
            'meeting'     => $meeting,
            'attendances' => $attendances,
            'settings'    => $settings,
        ];

        return view('attendance/live_board', $data);
    }

    /**
     * JSON Endpoint Polling Live Board
     */
    public function liveBoardApi($identifier)
    {
        $meeting = $this->resolveMeeting($identifier);
        if (!$meeting) {
            return $this->response->setJSON(['success' => false, 'message' => 'Meeting not found'])->setStatusCode(404);
        }

        $attendances = $this->attendanceModel->getByMeeting($meeting['id']);

        $totalHadir = 0;
        $totalOffline = 0;
        $totalOnline = 0;
        $totalIzin = 0;

        foreach ($attendances as $a) {
            if ($a['attendance_status'] === 'hadir_offline') {
                $totalHadir++;
                $totalOffline++;
            } elseif ($a['attendance_status'] === 'hadir_online') {
                $totalHadir++;
                $totalOnline++;
            } elseif (in_array($a['attendance_status'], ['izin', 'sakit'])) {
                $totalIzin++;
            }
        }

        return $this->response->setJSON([
            'success'       => true,
            'meeting_title' => $meeting['title'],
            'meeting_code'  => $meeting['meeting_code'],
            'total_all'     => count($attendances),
            'total_hadir'   => $totalHadir,
            'total_offline' => $totalOffline,
            'total_online'  => $totalOnline,
            'total_izin'    => $totalIzin,
            'attendances'   => $attendances,
        ]);
    }

    /**
     * Manajemen Daftar Hadir di Panel Admin
     */
    public function manage(int $meetingId)
    {
        $meeting = $this->meetingModel->getMeetingWithCounts($meetingId);
        if (!$meeting) {
            return redirect()->to(base_url('rapat'))->with('error', 'Rapat tidak ditemukan.');
        }

        $search = $this->request->getGet('q');
        $attendances = $this->attendanceModel->getByMeeting($meetingId, $search);
        $settings = $this->settingModel->getSettings();

        $data = [
            'title'       => 'Daftar Kehadiran: ' . $meeting['title'],
            'activeNav'   => 'meetings',
            'meeting'     => $meeting,
            'attendances' => $attendances,
            'search'      => $search,
            'settings'    => $settings,
        ];

        return view('attendance/manage', $data);
    }

    /**
     * Admin Tambah Peserta Manual
     */
    public function adminAdd(int $meetingId)
    {
        $meeting = $this->meetingModel->find($meetingId);
        if (!$meeting) {
            return redirect()->back()->with('error', 'Rapat tidak ditemukan.');
        }

        $name    = trim($this->request->getPost('participant_name') ?? '');
        $inst    = trim($this->request->getPost('institution') ?? '');
        $phone   = trim($this->request->getPost('phone') ?? '');
        $email   = trim($this->request->getPost('email') ?? '');
        $status  = trim($this->request->getPost('attendance_status') ?? 'hadir_offline');
        $notes   = trim($this->request->getPost('notes') ?? '');
        $sigData = $this->request->getPost('signature_data');

        if (empty($name)) {
            return redirect()->back()->withInput()->with('error', 'Nama peserta wajib diisi.');
        }

        $sigPath = null;
        if (!empty($sigData)) {
            $prefix = 'sig_' . preg_replace('/[^a-zA-Z0-9]/', '', substr($name, 0, 8));
            $sigPath = $this->attendanceModel->storeSignature($sigData, $prefix);
        }

        $this->attendanceModel->insert([
            'meeting_id'        => $meetingId,
            'participant_name'  => $name,
            'institution'       => !empty($inst) ? $inst : 'Pengurus / Tamu KOWPI',
            'phone'             => $phone,
            'email'             => $email,
            'attendance_status' => $status,
            'check_in_time'     => date('Y-m-d H:i:s'),
            'signature_image'   => $sigPath,
            'notes'             => $notes,
        ]);

        return redirect()->to(base_url("rapat/{$meetingId}/kehadiran"))->with('success', "Peserta {$name} berhasil ditambahkan!");
    }

    /**
     * Hapus Peserta
     */
    public function delete(int $id)
    {
        $att = $this->attendanceModel->find($id);
        if (!$att) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        if (!empty($att['signature_image']) && file_exists(FCPATH . $att['signature_image'])) {
            @unlink(FCPATH . $att['signature_image']);
        }

        $meetingId = $att['meeting_id'];
        $this->attendanceModel->delete($id);

        return redirect()->to(base_url("rapat/{$meetingId}/kehadiran"))->with('success', 'Data peserta berhasil dihapus.');
    }

    /**
     * Ekspor Daftar Hadir ke Excel
     */
    public function exportExcel(int $meetingId)
    {
        $meeting = $this->meetingModel->find($meetingId);
        if (!$meeting) {
            return redirect()->back()->with('error', 'Rapat tidak ditemukan.');
        }

        $attendances = $this->attendanceModel->getByMeeting($meetingId);
        $settings = $this->settingModel->getSettings();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Daftar Hadir');

        // Header KOWPI
        $sheet->setCellValue('A1', strtoupper($settings['org_name'] ?? 'KOMUNITAS WARIS PLANNING INDONESIA (KOWPI)'));
        $sheet->setCellValue('A2', 'DAFTAR HADIR PESERTA RAPAT DENGAN TANDA TANGAN DIGITAL');
        $sheet->setCellValue('A3', 'Judul Rapat : ' . $meeting['title']);
        $sheet->setCellValue('A4', 'Hari, Tanggal : ' . date('d F Y', strtotime($meeting['meeting_date'])) . ' | Pukul : ' . substr($meeting['start_time'], 0, 5) . ' - ' . substr($meeting['end_time'], 0, 5) . ' WIB');
        $sheet->setCellValue('A5', 'Tempat : ' . $meeting['location']);

        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');
        $sheet->mergeCells('A4:G4');
        $sheet->mergeCells('A5:G5');

        $sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A3:A5')->getFont()->setSize(10);

        // Table Header
        $headers = ['No', 'Nama Lengkap & Gelar', 'Instansi / Divisi', 'No. WhatsApp', 'Status Kehadiran', 'Waktu Hadir', 'Keterangan'];
        $col = 'A';
        $row = 7;
        foreach ($headers as $h) {
            $sheet->setCellValue($col . $row, $h);
            $col++;
        }

        $sheet->getStyle('A7:G7')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A7:G7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF582A1D');
        $sheet->getStyle('A7:G7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $row = 8;
        $no = 1;
        foreach ($attendances as $att) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $att['participant_name']);
            $sheet->setCellValue('C' . $row, $att['institution']);
            $sheet->setCellValue('D' . $row, $att['phone']);
            $sheet->setCellValue('E' . $row, ucwords(str_replace('_', ' ', $att['attendance_status'])));
            $sheet->setCellValue('F' . $row, date('H:i:s', strtotime($att['check_in_time'])));
            $sheet->setCellValue('G' . $row, $att['notes']);
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'G') as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Daftar_Hadir_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $meeting['meeting_code']) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
