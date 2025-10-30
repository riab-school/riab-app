<?php

use App\Models\AppLog;
use App\Models\AppSettings;
use App\Models\PsbConfig;
use App\Models\PsbHistory;
use App\Models\WhatsappChatHistory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

if(!function_exists('appSet')){
    function appSet($key){
        return AppSettings::where('key', $key)->first()->value;
    }
}

if(!function_exists('appLog')) {
    function appLog($user_id, $type, $description)
    {
        AppLog::create([
            'user_id'       => $user_id,
            'type'          => $type ? $type : NULL,
            'description'   => $description,
            'ip'            => $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_X_FORWARDED'] ?? $_SERVER['HTTP_FORWARDED_FOR'] ?? $_SERVER['HTTP_FORWARDED'] ?? null,
            'user_agent'    => $_SERVER['HTTP_USER_AGENT'],
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}

if(!function_exists('indoNumber')) {
    function indoNumber($number)
    {
        //Terlebih dahulu kita trim dl
        $number = trim($number);
        //bersihkan dari karakter yang tidak perlu
        $number = strip_tags($number);
        // Berishkan dari spasi
        $number = str_replace(" ", "", $number);
        // bersihkan dari tanda strip (-)
        $number = str_replace("-", "", $number);
        //bersihkan dari karakter +
        $number = str_replace("+", "", $number);
        // bersihkan dari bentuk seperti  (022) 66677788
        $number = str_replace("(", "", $number);
        // bersihkan dari format yang ada titik seperti 0811.222.333.4
        $number = str_replace(".", "", $number);

        //cek apakah mengandung karakter + dan 0-9
        if(!preg_match('/[^+0-9]/', trim($number))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($number), 0, 3) == '62') {
                $number = trim($number);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr($number, 0, 1) == '0') {
                $number = '62' . substr($number, 1);
            } elseif (substr($number, 0, 1) == '8') {
                $number = '62' . $number;
            }
        }
        return $number;
    }
}

if(!function_exists('whatsappNumber')) {
    function whatsappNumber($number)
    {
        return indoNumber($number)."@s.whatsapp.net";
    }
}

if (!function_exists('bulan')) {
    function bulan($bulan)
    {
        switch ($bulan) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

if(!function_exists('dateIndo')){
    function dateIndo($date)
    {
        $changeDate = gmdate($date, time() + 60 * 60 * 8);
        $parse = explode("-", $changeDate);
        $tanggal = $parse[2];
        $bulan = bulan($parse[1]);
        $tahun = $parse[0];
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
}

if(!function_exists('dateIndoShort')){
    function dateIndoShort($date)
    {
        $changeDate = gmdate($date, time() + 60 * 60 * 8);
        $parse = explode("-", $changeDate);
        $tanggal = $parse[2];
        $bulan = $parse[1];
        $tahun = $parse[0];
        return $tanggal . '-' . $bulan . '-' . $tahun;
    }
}

if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        return "Rp " . number_format($angka, 0, ',', '.');
    }
}

// Function get Desa
if (!function_exists('getVillage')) {
    function getVillage($desaId)
    {
        return \App\Models\Village::where('id', $desaId)->first()->name;
    }
}

//Function get District
if (!function_exists('getDistrict')) {
    function getDistrict($districtId)
    {
        return \App\Models\District::where('id', $districtId)->first()->name;
    }
}

//Function get City
if (!function_exists('getCity')) {
    function getCity($cityId)
    {
        return \App\Models\City::where('id', $cityId)->first()->name;
    }
}

//Function get Province
if (!function_exists('getProvince')) {
    function getProvince($provinceId)
    {
        return \App\Models\Province::where('id', $provinceId)->first()->name;
    }
}

if (!function_exists('penyebut')) {
    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . "Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
}

if (!function_exists('terbilang')) {
    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "Minus " . trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }
        return $hasil;
    }
}

if(!function_exists('isWaServerOnline')) {
    function isWaServerOnline()
    {
        $ch = curl_init(appSet('WHATSAPP_SERVER'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, appSet('WHATSAPP_API_KEY'));
        curl_exec($ch);
        $health = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($health == 200) {
            $response = true;
        } else {
            $response = false;
        }

        return $response;
    }
}

if(!function_exists('waStatus')){
    function waStatus()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => appSet('WHATSAPP_SERVER') . '/app/devices',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_USERPWD=> appSet('WHATSAPP_API_KEY'),
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}

if(!function_exists('sendText')) {
    function sendText($payload)
    {
        // Do curl to send text
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => appSet('WHATSAPP_SERVER') . '/send/message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_USERPWD=> appSet('WHATSAPP_API_KEY'),
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $status = json_decode($response);

        if($status->code == "SUCCESS"){
            $statusReport = "success";
        } elseif($status == "INVALID_JID"){
            $statusReport = "failed";
        } else {
            $statusReport = "failed";
        }

        // Store to DB
        WhatsappChatHistory::insert([
            'type'              => 'text',
            'category'          => $payload['category'] ?? NULL,
            'name'              => $payload['name'] ?? NULL,
            'phone'             => $payload['phone'],
            'message'           => $payload['message'],
            'response_id'       => $status->results->message_id ?? NULL,
            'response_status'   => $status->code,
            'response_message'  => $status->message ?? NULL,
            'process_status'    => $statusReport,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        if($statusReport == 'success'){
            return true;
        } else {
            return false;
        }
    }
}

if(!function_exists('sendImage')) {
    function sendImage($payload)
    {
        $payload['image_url'] = $payload['media_url'];
        $payload['view_once'] = false;
        $payload['compress'] = false;
        $payload['is_forwarded'] = false;
        
        // Do curl to send text
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => appSet('WHATSAPP_SERVER') . '/send/image',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_USERPWD=> appSet('WHATSAPP_API_KEY'),
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payload,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $status = json_decode($response);
        if($status->code == "SUCCESS"){
            $statusReport = "success";
        } elseif($status == "INVALID_JID"){
            $statusReport = "failed";
        } else {
            $statusReport = "failed";
        }

        // Store to DB
        WhatsappChatHistory::create([
            'type'              => $payload['type'],
            'category'          => $payload['category'] ?? NULL,
            'name'              => $payload['name'] ?? NULL,
            'phone'             => $payload['phone'],
            'message'           => $payload['caption'] ?? NULL,
            'media_url'         => $payload['media_url'] ?? NULL,
            'media_mime'        => $payload['media_mime'] ?? NULL,
            'response_id'       => $status->results->message_id ?? NULL,
            'response_status'   => $status->code,
            'response_message'  => $status->message ?? NULL,
            'process_status'    => $statusReport,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return response()->json([
            'status'    => $status->code == "SUCCESS" ? 'success' : 'failed',
            'code'      => $status->code,
            'response'  => $status
        ]);
    }
}

if (!function_exists('getTotalAyatInSurah')) {
    function getTotalAyatInSurah($surah)
    {
        $totalAyat = DB::table('master_alqurans')
            ->where('nomor_surah', $surah)
            ->value('total_ayat');
        return $totalAyat;
    }
}

if (!function_exists('getJuzProgress')) {
    function getJuzProgress($userId)
    {
        $memorizedAyats = DB::table('students_memorizations')
            ->where('user_id', $userId)
            ->get();

        $memorizedAyatKeys = [];

        foreach ($memorizedAyats as $memorization) {
            for ($i = $memorization->from_ayat; $i <= $memorization->to_ayat; $i++) {
                $key = $memorization->surah . ':' . $i;
                $memorizedAyatKeys[$key] = true;
            }
        }

        $juzList = DB::table('master_juzs')->get();

        $progress = [];

        foreach ($juzList as $juz) {
            $matchedAyats = 0;
            $totalAyats = 0;

            for (
                $surah = $juz->from_surah;
                $surah <= $juz->to_surah;
                $surah++
            ) {
                $startAyat = ($surah == $juz->from_surah) ? $juz->from_ayat : 1;
                $endAyat = ($surah == $juz->to_surah) ? $juz->to_ayat : getTotalAyatInSurah($surah); // Helper

                for ($i = $startAyat; $i <= $endAyat; $i++) {
                    $totalAyats++;
                    if (isset($memorizedAyatKeys["$surah:$i"])) {
                        $matchedAyats++;
                    }
                }
            }

            $percent = ($totalAyats > 0) ? round(($matchedAyats / $totalAyats) * 100, 2) : 0;

            $progress[] = [
                'juz' => $juz->juz,
                'percent' => $percent,
            ];
        }

        return $progress;
    }
}

if (!function_exists('getAyatRange')) {
    function getAyatRange($fromSurah, $fromAyat, $toSurah, $toAyat)
    {
        $ayatList = [];

        for ($surah = $fromSurah; $surah <= $toSurah; $surah++) {
            $totalAyat = getTotalAyatInSurah($surah);

            $start = ($surah == $fromSurah) ? $fromAyat : 1;
            $end = ($surah == $toSurah) ? $toAyat : $totalAyat;

            for ($ayat = $start; $ayat <= $end; $ayat++) {
                $ayatList[] = "{$surah}:{$ayat}";
            }
        }

        return $ayatList;
    }
}

if (!function_exists('getTotalAyatInSurah')) {
    function getTotalAyatInSurah($surah)
    {
        return DB::table('master_alqurans')
            ->where('nomor_surah', $surah)
            ->value('total_ayat');
    }
}

if (!function_exists('eventStatus')) {
    function eventStatus($start = null, $end = null, $single = null)
    {
        $today = Carbon::today();

        // Jika event punya rentang tanggal
        if ($start && $end) {
            $start = Carbon::parse($start);
            $end   = Carbon::parse($end);

            return [
                'is_ongoing' => $today->between($start, $end),
                'is_pass'    => $today->greaterThan($end),
            ];
        }

        // Jika event hanya 1 tanggal (pengumuman dsb.)
        if ($single) {
            $date = Carbon::parse($single);

            return [
                'is_ongoing' => $today->isSameDay($date),
                'is_pass'    => $today->greaterThan($date),
            ];
        }

        return ['is_ongoing' => false, 'is_pass' => false];
    }
}

if (!function_exists('getRejectedFile')) {
    function getRejectedFile($field)
    {
        $myDetail = auth()->user()->myDetail ?? null;
        if($field == null){
            return $myDetail->studentDocumentRejection()
                ->where('status', 'rejected')
                ->get();
        } else {
    
            if (!$myDetail || !method_exists($myDetail, 'studentDocumentRejection')) {
                return null;
            }
    
            return $myDetail->studentDocumentRejection()
                ->where('document_field_key', $field)
                ->where('status', 'rejected')
                ->first();
        }
    }
}

if (!function_exists('getJadwal')) {
    /**
     * Hitung jadwal ruang & sesi berdasarkan counter peserta.
     * Akan mengembalikan false jika kapasitas per hari sudah penuh.
     *
     * @param int $counter       urutan peserta yang sudah lolos administrasi
     * @param string|null $exam_date tanggal yang dipilih user (optional)
     * @return array|false
     */
    function getJadwal($counter, $exam_date = null)
    {
        $method  = request()->registration_method;
        $history = request()->registration_history;
        $config  = request()->psb_config;

        // === 0. Jalur efektif ===
        if (in_array($method, ['reguler', 'invited-reguler'])) {
            $method = 'reguler';
        }

        // === 1. Tentukan tanggal dasar ===
        if (!$exam_date) {
            $exam_date = ($method === 'reguler')
                ? $config->buka_tes_reguler
                : $config->buka_tes_undangan;
        }
        $exam_date = \Carbon\Carbon::parse($exam_date)->format('Y-m-d');

        // === 2. Hitung kapasitas maksimum per hari ===
        if ($method === 'reguler') {
            $kapasitasPerHari =
                ($config->kapasitas_ruang_cat ?? 33) *
                ($config->jumlah_ruang_cat ?? 3) *
                ($config->jumlah_sesi_sehari ?? 3);
        } else {
            // Jalur undangan: hanya interview santri & orang tua
            $kapasitasPerHari =
                ($config->kapasitas_ruang_interview ?? 9) *
                ($config->jumlah_ruang_interview ?? 11) *
                ($config->jumlah_sesi_sehari ?? 3);
        }

        // === 3. Cek limit harian ===
        if ($counter > $kapasitasPerHari) {
            // Hari penuh, user tidak bisa pilih tanggal ini
            return false;
        }

        // === 4. Pengaturan CAT (khusus reguler & invited-reguler) ===
        $ruangCat = $sesiCat = null;
        if ($method === 'reguler') {
            $kapasitasCat     = $config->kapasitas_ruang_cat ?? 33;
            $jumlahRuangCat   = $config->jumlah_ruang_cat ?? 3;
            $prefixCat        = $config->prefix_ruang_cat ?? 'Ruang CAT ';

            $ruangCatNumber   = ceil($counter / $kapasitasCat);
            $ruangCatNumber   = (($ruangCatNumber - 1) % $jumlahRuangCat) + 1;
            $sesiIndex        = ceil($counter / ($kapasitasCat * $jumlahRuangCat));
            $sesiCat          = "Sesi " . $sesiIndex;
            $ruangCat         = $prefixCat . $ruangCatNumber;
        }

        // === 5. Pengaturan Interview Santri (semua jalur) ===
        $kapasitasInterview     = $config->kapasitas_ruang_interview ?? 9;
        $jumlahRuangInterview   = $config->jumlah_ruang_interview ?? 11;
        $prefixInterview         = $config->prefix_ruang_interview ?? 'Ruang Interview ';

        $ruangInterviewNumber   = ceil($counter / $kapasitasInterview);
        $ruangInterviewNumber   = (($ruangInterviewNumber - 1) % $jumlahRuangInterview) + 1;
        $sesiIndexInterview     = ceil($counter / ($kapasitasInterview * $jumlahRuangInterview));
        $sesiInterview          = "Sesi " . $sesiIndexInterview;
        $ruangInterview         = $prefixInterview . $ruangInterviewNumber;

        // === 6. Pengaturan Interview Orang Tua (semua jalur) ===
        $kapasitasOrtu     = $config->kapasitas_ruang_interview_orangtua ?? 33;
        $jumlahRuangOrtu   = $config->jumlah_ruang_interview_orangtua ?? 3;
        $prefixOrtu         = $config->prefix_ruang_interview_orangtua ?? 'Ruang Orang Tua ';

        $ruangOrtuNumber   = ceil($counter / $kapasitasOrtu);
        $ruangOrtuNumber   = (($ruangOrtuNumber - 1) % $jumlahRuangOrtu) + 1;
        $sesiIndexOrtu     = ceil($counter / ($kapasitasOrtu * $jumlahRuangOrtu));
        $sesiOrtu          = "Sesi " . $sesiIndexOrtu;
        $ruangOrtu         = $prefixOrtu . $ruangOrtuNumber;

        // === 7. Return hasil ===
        return [
            'exam_date' => $exam_date,
            'ruang_cat' => $ruangCat,
            'sesi_cat' => $sesiCat,
            'ruang_interview' => $ruangInterview,
            'sesi_interview' => $sesiInterview,
            'ruang_interview_orangtua' => $ruangOrtu,
            'sesi_interview_orangtua' => $sesiOrtu,
        ];
    }
}

if (!function_exists('getCounter')) {
    function getCounter($user_id)
    {
        return DB::transaction(function () use ($user_id) {
            $history = PsbHistory::where('user_id', $user_id)
                ->where('is_paid', 1)
                ->where('is_administration_confirmed', 1)
                ->lockForUpdate()
                ->first();

            if (!$history) {
                return null;
            }

            // ambil konfigurasi PSB aktif langsung dari DB (bukan dari request)
            $config = PsbConfig::where('is_active', true)->first();

            // kalau history belum punya exam_number, generate baru
            if (!$history->exam_number) {
                $lastNumber = PsbHistory::lockForUpdate()
                    ->whereNotNull('exam_number')
                    ->orderBy('exam_number', 'desc')
                    ->value('exam_number');

                $nextNumber = str_pad(((int) ($lastNumber ?? 0)) + 1, 3, '0', STR_PAD_LEFT);

                $history->update(['exam_number' => $nextNumber]);
            }

            return $history->exam_number;
        });
    }
}

if (!function_exists('convertSesiToJam')) {
    /**
     * Ganti teks "Sesi X" menjadi rentang waktu.
     *
     * @param  string  $text
     * @return string
     */
    function convertSesiToJam($text)
    {
        $mapping = [
            'Sesi 1' => '08:00 s/d 09:30',
            'Sesi 2' => '09:30 s/d 11:00',
            'Sesi 3' => '11:00 s/d 12:30',
            'Sesi 4' => '13:00 s/d 14:30',
            'Sesi 5' => '14:30 s/d 16:00',
            'Sesi 6' => '16:00 s/d 17:30',
        ];

        return $mapping[$text] ?? $text;
    }
}








