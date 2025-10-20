<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PsbConfig;
use Illuminate\Http\Request;
Use Storage;

class PsbInfo extends Controller
{
    public function index()
    {
        $psbConfig = PsbConfig::where('is_active', true)->first();
        if ($psbConfig) {
            $psbConfig = $psbConfig->setHidden([
                'id',
                'target_undangan',
                'target_reguler',
                'kode_undangan',
                'is_active',
                'created_at',
                'updated_at',
            ]);

            if ($psbConfig->buka_daftar_undangan > now() && $psbConfig->buka_daftar_reguler > now()) {
                $statusUndangan = 'not-yet';
                $statusReguler = 'not-yet';
            }

            if ($psbConfig->buka_daftar_undangan < now() && $psbConfig->tutup_daftar_undangan > now()) {
                $statusUndangan = 'open';
                $statusReguler = 'not-yet';
            }

            if ($psbConfig->tutup_daftar_undangan < now() && $psbConfig->buka_daftar_reguler > now()) {
                $statusUndangan = 'closed';
                $statusReguler = 'not-yet';
            }

            if ($psbConfig->buka_daftar_reguler < now() && $psbConfig->tutup_daftar_reguler > now()) {
                $statusUndangan = 'closed';
                $statusReguler = 'open';
            }

            $psbConfig->brosur_link = Storage::disk('s3')->url($psbConfig->brosur_link);
            $psbConfig->booklet_link = Storage::disk('s3')->url($psbConfig->booklet_link);

            $psbStatus = true;
        } else {
            $psbStatus = false;
        }

        $data = [
            'error'                 => false,
            'message'               => 'Fetching data success',
            'is_psb_open'           => $psbStatus,
            'undangan_status'       => $statusUndangan ?? 'closed',
            'reguler_status'        => $statusReguler ?? 'closed',
            'data'                  => $psbConfig,
        ];

        return response()->json($data, 200);
    }
}
