<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PsbConfig;
use Carbon\Carbon;

class CheckPsbSchedule
{
    /**
     * $type = register | verify  | daftar_ulang | pengumuman
     */
    public function handle(Request $request, Closure $next, $type)
    {
        $config = PsbConfig::where('is_active', true)->first();
        if (! $config) {
            return $this->reject($request, 'Konfigurasi PSB belum diaktifkan.');
        }

        $regMethod = $request->registration_method ?? 'reguler';
        $history = $request->registration_history;
        $now = Carbon::now();

        $map = [
            'register' => [
                'open' => 'buka_daftar_',
                'msg' => 'Pendaftaran belum dibuka.',
                'open_only' => true,
            ],
            'verify' => [
                'open' => 'buka_verifikasi_berkas_',
                'msg' => 'Verifikasi berkas belum dibuka.',
                'open_only' => true,
            ],
            'exam' => [
                'open' => 'buka_tes_',
                'msg' => 'Ujian belum dimulai.',
                'open_only' => true, // ✅ sekarang pure waktu aja
            ],
            'daftar_ulang' => [
                'open' => 'buka_daftar_ulang_',
                'msg' => 'Masa daftar ulang belum dibuka.',
                'open_only' => true,
            ],
            'pengumuman' => [
                'custom' => function ($config, $regMethod, $now) {
                    if ($regMethod === 'invited') {
                        $tglAdm = $config->pengumuman_administrasi_undangan;
                        $tglFinal = $config->pengumuman_undangan;
                        return $now->gte(\Carbon\Carbon::parse($tglAdm))
                            || $now->gte(\Carbon\Carbon::parse($tglFinal));
                    }

                    $tglReg = $config->pengumuman_reguler;
                    return $now->gte(\Carbon\Carbon::parse($tglReg));
                },
                'msg' => 'Belum waktu pengumuman, silahkan menunggu jadwal resmi dari panitia.',
            ],
        ];


        if (! isset($map[$type])) {
            return $this->reject($request, 'Jenis jadwal PSB tidak dikenali.');
        }

        $schedule = $map[$type];

        // 🧩 1. Custom (pengumuman)
        if (isset($schedule['custom'])) {
            $allowed = $schedule['custom']($config, $regMethod, $now);
            if (! $allowed) {
                return $this->reject($request, $schedule['msg']);
            }
            return $next($request);
        }

        // helper: check tanggal buka
        $isOpen = function (?string $openVal, bool $openOnly) use ($now): bool {
            if (! $openVal) return false;
            try {
                $start = Carbon::parse($openVal);
            } catch (\Exception $e) {
                return false;
            }
            return $now->gte($start);
        };

        // 🧩 3. invited-reguler (boleh jika salah satu sudah buka)
        if ($regMethod === 'invited-reguler') {
            $openUnd = $config->{$schedule['open'].'undangan'} ?? null;
            $openReg = $config->{$schedule['open'].'reguler'} ?? null;

            if ($isOpen($openUnd, true) || $isOpen($openReg, true)) {
                return $next($request);
            }

            return $this->reject($request, $schedule['msg']);
        }

        // 🧩 4. invited / reguler normal
        $suffix = ($regMethod === 'invited') ? 'undangan' : 'reguler';
        $open = $config->{$schedule['open'].$suffix} ?? null;

        if (! $isOpen($open, true)) {
            return $this->reject($request, $schedule['msg']);
        }

        return $next($request);
    }

    protected function reject(Request $request, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 403);
        }
        return redirect()->route('student.home.new')->with([
            'status' => 'error',
            'message' => $message,
        ]);
    }
}
