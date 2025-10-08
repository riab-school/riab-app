<?php

namespace App\Http\Controllers\Student\New;

use App\Http\Controllers\Controller;
use App\Models\PsbConfig;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $config = PsbConfig::where('is_active', true)->first();
        if (!$config) {
            $data = [
                'events' => [],
                'registration_method' => $request->registration_method,
            ];
            return view('app.student.new.dashboard', $data);
        }
        
        $eventsUndangan = [
            [
                'order' => 1,
                'title' => 'Pendaftaran',
                'date'  => $config->buka_daftar_undangan .' s/d '. $config->tutup_daftar_undangan,
                'color' => 'bg-c-green',
                'desc'  => 'Calon santri harus mendaftarkan akun, dan mengisi form yang telah disediakan',
                'button'=> [
                    'text' => 'Lengkapi Form',
                    'url'  => route('student.new.data-diri'),
                ],
            ] + eventStatus($config->buka_daftar_undangan, $config->tutup_daftar_undangan),

            [
                'order' => 2,
                'title' => 'Verifikasi Berkas',
                'date'  => $config->buka_verifikasi_berkas_undangan .' s/d '. $config->tutup_verifikasi_berkas_undangan,
                'color' => 'bg-c-blue',
                'desc'  => 'Berkas calon santri akan diverifikasi oleh panitia',
                'button'=> [],
            ] + eventStatus($config->buka_verifikasi_berkas_undangan, $config->tutup_verifikasi_berkas_undangan),

            [
                'order' => 3,
                'title' => 'Pengumuman Verifikasi Berkas',
                'date'  => $config->pengumuman_administrasi_undangan,
                'color' => 'bg-c-yellow',
                'desc'  => 'Calon santri dapat melihat hasil verifikasi berkas untuk penentuan kelulusan seleksi undangan',
                'button'=> [],
            ] + eventStatus(null, null, $config->pengumuman_administrasi_undangan),

            [
                'order' => 4,
                'title' => 'Test Wawancara',
                'date'  => $config->buka_tes_undangan .' s/d '. $config->tutup_tes_undangan,
                'color' => 'bg-c-purple',
                'desc'  => 'Calon santri yang lolos verifikasi berkas dapat mengikuti test wawancara',
                'button'=> [],
            ] + eventStatus($config->buka_tes_undangan, $config->tutup_tes_undangan),

            [
                'order' => 5,
                'title' => 'Pengumuman Hasil Akhir',
                'date'  => $config->pengumuman_undangan,
                'color' => 'bg-c-red',
                'desc'  => 'Calon santri dapat melihat hasil akhir seleksi undangan',
                'button'=> [],
            ] + eventStatus(null, null, $config->pengumuman_undangan),

            [
                'order' => 6,
                'title' => 'Daftar Ulang',
                'date'  => $config->buka_daftar_ulang_undangan .' s/d '. $config->tutup_daftar_ulang_undangan,
                'color' => 'bg-success',
                'desc'  => 'Calon santri yang dinyatakan lulus dapat melakukan daftar ulang',
                'button'=> [],
            ] + eventStatus($config->buka_daftar_ulang_undangan, $config->tutup_daftar_ulang_undangan),
        ];

        $eventsReguler = [
            [
                'order' => 1,
                'title' => 'Pendaftaran',
                'date'  => $config->buka_daftar_reguler .' s/d '. $config->tutup_daftar_reguler,
                'color' => 'bg-c-green',
                'desc'  => 'Calon santri harus mendaftarkan akun, dan mengisi form yang telah disediakan'
            ],
            [
                'order' => 2,
                'title' => 'Verifikasi Berkas',
                'date'  => $config->buka_verifikasi_berkas_reguler .' s/d '. $config->tutup_verifikasi_berkas_reguler,
                'color' => 'bg-c-blue',
                'desc'  => 'Berkas calon santri akan diverifikasi oleh panitia'
            ],
            [
                'order' => 3,
                'title' => 'Cetak Berkas',
                'date'  => $config->buka_cetak_berkas .' s/d '. $config->tutup_cetak_berkas,
                'color' => 'bg-c-yellow',
                'desc'  => 'Calon santri yang lolos verifikasi berkas dapat mencetak berkas untuk ujian CAT dan wawancara'
            ],
            [
                'order' => 4,
                'title' => 'Ujian CAT dan Wawancara',
                'date'  => $config->buka_tes_reguler .' s/d '. $config->tutup_tes_reguler,
                'color' => 'bg-c-purple',
                'desc'  => 'Calon santri yang lolos verifikasi berkas dapat mengikuti ujian CAT dan wawancara'
            ],
            [
                'order' => 5,
                'title' => 'Pengumuman Hasil Akhir',
                'date'  => $config->pengumuman_reguler,
                'color' => 'bg-c-red',
                'desc'  => 'Calon santri dapat melihat hasil akhir seleksi reguler'
            ],
            [
                'order' => 6,
                'title' => 'Daftar Ulang',
                'date'  => $config->buka_daftar_ulang_reguler .' s/d '. $config->tutup_daftar_ulang_reguler,
                'color' => 'bg-success',
                'desc'  => 'Calon santri yang dinyatakan lulus dapat melakukan daftar ulang'
            ]
        ];

        if($request->registration_method == 'invited'){
            $events = $eventsUndangan;
        } elseif($request->registration_method == "invited-reguler"){
            $events = $eventsReguler;
        } else {
            $events = $eventsReguler;
        }

        foreach ($events as &$event) {
            if (!empty($event['date'])) {
                // kalau ada " s/d " berarti range
                if (str_contains($event['date'], 's/d')) {
                    [$start, $end] = explode(' s/d ', $event['date']);
                    $event['date'] = Carbon::parse($start)->format('d-M') 
                                . ' s/d ' 
                                . Carbon::parse($end)->format('d-M');
                } else {
                    $event['date'] = Carbon::parse($event['date'])->format('d-M');
                }
            }
        }
        unset($event); // penting untuk referensi array

        // Urutkan berdasarkan order
        usort($events, function ($a, $b) {
            return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
        });

        $data = [
            'events' => $events,
            'registration_method' => $request->registration_method,
        ];
        return view('app.student.new.dashboard', $data);
    }
}
