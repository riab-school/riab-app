<?php

use App\Models\AppLog;
use App\Models\AppSettings;
use App\Models\WhatsappChatHistory;
use Illuminate\Support\Facades\DB;

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
        return "Rp. " . number_format($angka, 0, ',', '.');
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

function getTotalAyatInSurah($surah)
{
    return DB::table('master_alqurans')
        ->where('nomor_surah', $surah)
        ->value('total_ayat');
}

