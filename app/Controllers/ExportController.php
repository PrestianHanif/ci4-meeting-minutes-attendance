<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MeetingModel;
use App\Models\AttendanceModel;
use App\Models\MeetingMinutesModel;
use App\Models\DocumentationModel;
use App\Models\SettingModel;
use Mpdf\Mpdf;

class ExportController extends BaseController
{
    protected MeetingModel $meetingModel;
    protected AttendanceModel $attendanceModel;
    protected MeetingMinutesModel $minutesModel;
    protected DocumentationModel $docModel;
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->meetingModel    = new MeetingModel();
        $this->attendanceModel = new AttendanceModel();
        $this->minutesModel    = new MeetingMinutesModel();
        $this->docModel        = new DocumentationModel();
        $this->settingModel    = new SettingModel();
    }

    /**
     * Tampilan Dokumen Cetak / Preview Siap Print (Kop Resmi KOWPI, Notula, Daftar Hadir Ber-TTD, Foto)
     */
    public function printView(int $meetingId)
    {
        $meeting = $this->meetingModel->getMeetingWithCounts($meetingId);
        if (!$meeting) {
            return redirect()->to(base_url('rapat'))->with('error', 'Rapat tidak ditemukan.');
        }

        $minutes = $this->minutesModel->getOrInit($meetingId);
        $attendances = $this->attendanceModel->getByMeeting($meetingId);
        $photos = $this->docModel->getByMeeting($meetingId);
        $settings = $this->settingModel->getSettings();

        $actionItems = [];
        if (!empty($minutes['action_items'])) {
            $decoded = json_decode($minutes['action_items'], true);
            if (is_array($decoded)) {
                $actionItems = $decoded;
            }
        }

        $data = [
            'title'       => 'Cetak Berkas Rapat - ' . $meeting['meeting_code'],
            'meeting'     => $meeting,
            'minutes'     => $minutes,
            'actionItems' => $actionItems,
            'attendances' => $attendances,
            'photos'      => $photos,
            'settings'    => $settings,
        ];

        return view('export/print_dokumen', $data);
    }

    /**
     * Unduh PDF Berkas Lengkap (Notula + Presensi Ber-TTD + Foto) via mPDF
     */
    public function completeMeetingPdf(int $meetingId)
    {
        $meeting = $this->meetingModel->getMeetingWithCounts($meetingId);
        if (!$meeting) {
            return redirect()->to(base_url('rapat'))->with('error', 'Rapat tidak ditemukan.');
        }

        $minutes = $this->minutesModel->getOrInit($meetingId);
        $attendances = $this->attendanceModel->getByMeeting($meetingId);
        $photos = $this->docModel->getByMeeting($meetingId);
        $settings = $this->settingModel->getSettings();

        $actionItems = [];
        if (!empty($minutes['action_items'])) {
            $decoded = json_decode($minutes['action_items'], true);
            if (is_array($decoded)) {
                $actionItems = $decoded;
            }
        }

        $html = view('export/pdf_complete', [
            'meeting'     => $meeting,
            'minutes'     => $minutes,
            'actionItems' => $actionItems,
            'attendances' => $attendances,
            'photos'      => $photos,
            'settings'    => $settings,
        ]);

        $mpdf = new Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_left'   => 18,
            'margin_right'  => 18,
            'margin_top'    => 20,
            'margin_bottom' => 20,
            'default_font'  => 'sans-serif'
        ]);

        $mpdf->SetTitle('Berkas Rapat ' . $meeting['meeting_code']);
        $mpdf->SetAuthor('KOWPI.id');
        $mpdf->WriteHTML($html);

        $filename = 'Berkas_Rapat_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $meeting['meeting_code']) . '.pdf';
        $mpdf->Output($filename, 'I');
        exit;
    }

    /**
     * Unduh PDF Khusus Notula
     */
    public function notulaPdf(int $meetingId)
    {
        return $this->completeMeetingPdf($meetingId);
    }

    /**
     * Unduh PDF Khusus Daftar Hadir
     */
    public function attendancePdf(int $meetingId)
    {
        return $this->completeMeetingPdf($meetingId);
    }
}
