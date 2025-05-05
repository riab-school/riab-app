<?php

use App\Models\AppLog;
use App\Models\AppSettings;
use App\Models\WhatsappChatHistory;

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
        curl_exec($ch);
        $health = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $time = curl_getinfo($ch, CURLINFO_CONNECT_TIME_T);
        curl_close($ch);
        if ($health == 200) {
            $response = true;
        } else {
            $response = false;
        }

        return $response;
    }
}

if(!function_exists('isOnWhatsapp')) {
    function isOnWhatsapp($data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => appSet('WHATSAPP_SERVER') . '/user/check',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'token: ' . appSet('WHATSAPP_TOKEN'),
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        return $response;
    }
}

if(!function_exists('waQr')) {
    function waQr(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => appSet('WHATSAPP_SERVER') . '/session/qr',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'token: ' . appSet('WHATSAPP_TOKEN')
            ),
        ));
    
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}

if(!function_exists('connect')){
    function connect()
    {
        $payload = [
            'Subscribe' => [
                'ReadReceipt'
            ],
            'Immediate' => true
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => appSet('WHATSAPP_SERVER') . '/session/connect',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'token: ' . appSet('WHATSAPP_TOKEN')
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}

if(!function_exists('disconnect')){
    function disconnect()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => appSet('WHATSAPP_SERVER') . '/session/logout',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'token: ' . appSet('WHATSAPP_TOKEN')
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}

if(!function_exists('waStatus')){
    function waStatus()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => appSet('WHATSAPP_SERVER') . '/session/status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'token: ' . appSet('WHATSAPP_TOKEN')
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}

if(!function_exists('sendPresence')) {
    function sendPresence($phone)
    {
        $presenceData = [
            'Phone' => indoNumber($phone),
            'State' => 'composing'
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => appSet('WHATSAPP_SERVER') . '/chat/presence',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($presenceData),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'token: ' . appSet('WHATSAPP_TOKEN'),
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}

if(!function_exists('sendText')) {
    function sendText($payload, $compose = false)
    {

        // Check is On Whatsapp
        $check = isOnWhatsapp(['Phone' => [indoNumber($payload['Phone'])]]);
        if(!$check['data']['Users'][0]['IsInWhatsapp']){
            WhatsappChatHistory::create([
                'type'              => 'text',
                'category'          => $payload['Category'] ?? NULL,
                'name'              => NULL,
                'phone'             => $payload['Phone'],
                'message'           => $payload['Body'],
                'response_id'       => NULL,
                'response_status'   => 0,
                'response_message'  => "Gagal, nomor tidak terdaftar di whatsapp.",
                'process_status'    => 'failed',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
            return false;
        }

        // Do typing.. if true
        if($compose){
            sendPresence($payload['Phone']);
            sleep(5);
        }
        
        // Do curl to send text
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => appSet('WHATSAPP_SERVER') . '/chat/send/text',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'token: ' . appSet('WHATSAPP_TOKEN'),
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        // Store to DB
        WhatsappChatHistory::create([
            'type'              => 'text',
            'category'          => $payload['Category'] ?? NULL,
            'name'              => $payload['Name'] ?? NULL,
            'phone'             => $payload['Phone'],
            'message'           => $payload['Body'],
            'response_id'       => json_decode($response)->data->Id ?? NULL,
            'response_status'   => json_decode($response)->success ?? 0,
            'response_message'  => json_decode($response)->success ? "Berhasil" : "Gagal",
            'process_status'    => json_decode($response)->success ? 'success' : 'failed',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil',
            'data' => json_decode($response)
        ]);
    }
}




