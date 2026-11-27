<?php

namespace App\Services;

use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class PdfGeneratorService
{
    protected array $settings;

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
        if (function_exists('helper')) {
            helper(['url', 'html']);
        }
    }

    /**
     * Create configured mPDF instance
     */
    protected function getMpdfInstance(): Mpdf
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $customFontDir = FCPATH . 'assets/fonts';

        $mpdf = new Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A5', // Standar Kertas Undangan Resmi A5 (148mm x 210mm)
            'margin_left'   => 7,
            'margin_right'  => 7,
            'margin_top'    => 7,
            'margin_bottom' => 7,
            'fontDir'       => array_merge($fontDirs, [$customFontDir]),
            'fontdata'      => $fontData + [
                'notoserif' => [
                    'R' => 'NotoSerif-Regular.ttf',
                    'B' => 'NotoSerif-Bold.ttf',
                    'I' => 'NotoSerif-Italic.ttf',
                ],
            ],
            'default_font'  => 'notoserif',
            'tempDir'       => WRITEPATH . 'cache',
        ]);

        $mpdf->SetAuthor('Universitas Islam Indonesia & KOWPI');
        $mpdf->SetCreator('Sistem Undangan Sidang Promosi Doktor UII - KOWPI');
        $mpdf->SetSubject('Undangan Ujian Terbuka (Promosi Doktor) - Muhammad Abu Rivai, S.H., M.H.');

        return $mpdf;
    }

    /**
     * Generate QR Code as base64 PNG data-uri
     */
    public function generateQrCode(string $text): string
    {
        return (new QRCode())->render($text);
    }

    /**
     * Render the 3 pages HTML for a guest
     */
    public function renderHtml(array $guest, array $settings): string
    {
        $baseUrl = function_exists('base_url') ? base_url() : 'http://localhost/app-undangan-doktor/';
        $mapsUrl = 'https://maps.app.goo.gl/jbxZwqgbMHjEpuUN8'; // Link Google Maps Gedung FIAI UII (Sesuai Permintaan User)
        $guestCode = urlencode($guest['guest_code'] ?? 'KOWPI-001');
        $guestBookUrl = function_exists('base_url') ? base_url('absensi?code=' . $guestCode) : 'http://localhost/app-undangan-doktor/absensi?code=' . $guestCode;

        $mapsQr = $this->generateQrCode($mapsUrl);
        $guestBookQr = $this->generateQrCode($guestBookUrl);

        $logoUii = FCPATH . 'assets/img/logo-uii.png';
        $logoKowpi = FCPATH . 'assets/img/logo-kowpi-coklat.png';
        $denahImg = file_exists(FCPATH . 'assets/img/denah-lokasi-fiai.png')
            ? FCPATH . 'assets/img/denah-lokasi-fiai.png'
            : FCPATH . 'assets/img/denah-lokasi-fiai.svg';
        $denahSvg = $denahImg;
        $stempelSvg = FCPATH . 'assets/img/stempel-fiai-uii.svg';
        $ttdSvg = FCPATH . 'assets/img/ttd-dekan.svg';
        $stempelTtdImg = FCPATH . 'assets/img/ttd-dan-stempel-dekan.png';

        // Tanggal dinamis otomatis menyesuaikan hari saat surat diunduh/dilihat
        $bulanIndo = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        $currentDay = date('d');
        $currentMonth = $bulanIndo[(int)date('n')] ?? date('F');
        $currentYear = date('Y');
        $letterDate = 'Yogyakarta, ' . $currentDay . ' ' . $currentMonth . ' ' . $currentYear;

        $stempelTtdImg = FCPATH . 'assets/img/ttd-dan-stempel-dekan.png';
        $dekanImg = $this->getDekanImage();
        $stempelKowpiImg = file_exists(FCPATH . 'assets/img/stempel-kowpi-transparan.png')
            ? FCPATH . 'assets/img/stempel-kowpi-transparan.png'
            : FCPATH . 'assets/img/Stempel KOWPI.png';

        $data = [
            'guest'           => $guest,
            'settings'        => $settings,
            'mapsQr'          => $mapsQr,
            'guestBookQr'     => $guestBookQr,
            'logoUii'         => $logoUii,
            'logoKowpi'       => $logoKowpi,
            'denahImg'        => $denahImg,
            'denahSvg'        => $denahSvg,
            'stempelSvg'      => $stempelSvg,
            'ttdSvg'          => $ttdSvg,
            'stempelTtdImg'   => $stempelTtdImg,
            'dekanImg'        => $dekanImg,
            'stempelKowpiImg' => $stempelKowpiImg,
            'letterDate'      => $letterDate,
            'mapsUrl'         => $mapsUrl,
            'guestBookUrl'    => $guestBookUrl,
        ];

        return view('pdf/invitation_template', $data);
    }

    /**
     * Generate PDF for a single guest
     *
     * @param array $guest
     * @param array $settings
     * @param string $dest 'I' (Inline), 'D' (Download), 'F' (Save File), 'S' (String)
     * @param string|null $savePath
     * @return string|null
     */
    public function generate(array $guest, array $settings, string $dest = 'I', ?string $savePath = null)
    {
        $mpdf = $this->getMpdfInstance();

        $html = $this->renderHtml($guest, $settings);
        $mpdf->WriteHTML($html);

        $filename = !empty($guest['pdf_filename'])
            ? $guest['pdf_filename']
            : 'Undangan_Promosi_Doktor_' . str_replace(' ', '_', $guest['full_name']) . '.pdf';

        if ($dest === 'F' && $savePath) {
            $dir = dirname($savePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $mpdf->Output($savePath, \Mpdf\Output\Destination::FILE);
            return $savePath;
        }

        if ($dest === 'D') {
            $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
            exit();
        }

        if ($dest === 'S') {
            return $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
        }

        // Default 'I': Inline preview in browser
        $mpdf->Output($filename, \Mpdf\Output\Destination::INLINE);
        exit();
    }

    /**
     * Generate combined PDF for multiple guests (All-in-One print-ready)
     */
    public function generateMultiple(array $guests, array $settings, string $dest = 'I', ?string $savePath = null, string $filename = 'Undangan_Kompilasi.pdf')
    {
        $mpdf = $this->getMpdfInstance();

        $total = count($guests);
        $i = 0;
        foreach ($guests as $guest) {
            $i++;
            $html = $this->renderHtml($guest, $settings);
            $mpdf->WriteHTML($html);
            if ($i < $total) {
                $mpdf->WriteHTML('<pagebreak />');
            }
        }

        if ($dest === 'F' && $savePath) {
            $dir = dirname($savePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $mpdf->Output($savePath, \Mpdf\Output\Destination::FILE);
            return $savePath;
        }

        if ($dest === 'D') {
            $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
            exit();
        }

        if ($dest === 'S') {
            return $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
        }

        $mpdf->Output($filename, \Mpdf\Output\Destination::INLINE);
        exit();
    }

    /**
     * Get or generate the official signatory image (dekan.png) with dynamic download date
     */
    public function getDekanImage(): string
    {
        $baseDekan = FCPATH . 'assets/img/dekan.png';
        if (!file_exists($baseDekan)) {
            return FCPATH . 'assets/img/ttd-dan-stempel-dekan.png';
        }

        $bulanIndo = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        $currentDay = date('d');
        $currentMonth = $bulanIndo[(int)date('n')] ?? date('F');
        $currentYear = date('Y');
        $dateText = ' ' . $currentDay . ' ' . $currentMonth . ' ' . $currentYear;

        // Path cached per-day to avoid re-generating on every page
        $dateSlug = date('Ymd');
        $renderedImg = FCPATH . "assets/img/dekan_rendered_{$dateSlug}.png";

        if (file_exists($renderedImg)) {
            return $renderedImg;
        }

        // Process image: make background transparent and render dynamic date
        if (function_exists('imagecreatefrompng')) {
            $im = @imagecreatefrompng($baseDekan);
            if ($im) {
                $w = imagesx($im);
                $h = imagesy($im);

                $out = imagecreatetruecolor($w, $h);
                imagealphablending($out, false);
                imagesavealpha($out, true);
                $trans = imagecolorallocatealpha($out, 0, 0, 0, 127);
                imagefilledrectangle($out, 0, 0, $w, $h, $trans);

                for ($y = 0; $y < $h; $y++) {
                    for ($x = 0; $x < $w; $x++) {
                        $c = imagecolorat($im, $x, $y);
                        $a = ($c >> 24) & 0x7F;
                        if ($a == 127) continue;

                        $r = ($c >> 16) & 0xFF;
                        $g = ($c >> 8) & 0xFF;
                        $b = $c & 0xFF;

                        $lum = 0.299 * $r + 0.587 * $g + 0.114 * $b;

                        // Background white/light threshold
                        if ($lum > 238) {
                            continue;
                        }

                        $outAlpha = $a;
                        if ($lum > 215) {
                            $edgeAlpha = (int)(127 * (($lum - 215) / 23));
                            $outAlpha = max($a, $edgeAlpha);
                        }

                        if ($outAlpha >= 120) continue;

                        $col = imagecolorallocatealpha($out, $r, $g, $b, $outAlpha);
                        imagesetpixel($out, $x, $y, $col);
                    }
                }

                // Draw dynamic date
                $font = 'C:/Windows/Fonts/calibri.ttf';
                if (!file_exists($font)) {
                    $font = 'C:/Windows/Fonts/arial.ttf';
                }

                if (file_exists($font) && function_exists('imagettftext')) {
                    imagealphablending($out, true);
                    $textColor = imagecolorallocate($out, 15, 23, 42);
                    @imagettftext($out, 23, 0, 515, 72, $textColor, $font, $dateText);
                }

                @imagepng($out, $renderedImg);
                @imagedestroy($im);
                @imagedestroy($out);

                if (file_exists($renderedImg)) {
                    return $renderedImg;
                }
            }
        }

        return $baseDekan;
    }
}
