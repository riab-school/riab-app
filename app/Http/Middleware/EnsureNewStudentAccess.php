<?php

namespace App\Http\Middleware;

use App\Models\PsbConfig;
use App\Models\PsbHistory;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNewStudentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Validasi akses berdasarkan level pengguna dan status
        if($user->user_level !== 'student' || $user->myDetail->status !== 'new'){
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini'
            ]);
        }

        $history = PsbHistory::where('user_id', $user->id)->with('studentDetail', 'userDetail', 'psbConfig', 'studentCatRoom', 'studentInterviewRoom', 'parentInterviewRoom')->first();

        // Validasi keberadaan data siswa
        if (!$history) {
            abort(404, 'Data siswa tidak ditemukan di database');
        }

        // Tentukan metode pendaftaran berdasarkan history
        $registrationMethod = match (true) {
            $history->registration_method === 'invited' && !$history->is_moved_to_non_invited => 'invited',
            $history->registration_method === 'invited' && $history->is_moved_to_non_invited => 'invited-reguler',
            $history->registration_method === 'reguler' && !$history->is_moved_to_non_invited => 'reguler',
            default => null,
        };

        // Ambil konfigurasi PSB dari session atau database
        $psbConfig = PsbConfig::where('is_active', true)->first();

        // Tambahkan data ke request
        $request->merge([
            'registration_history' => $history,
            'registration_method' => $registrationMethod,
            'psb_config' => $psbConfig,
            'home_url' => route('student.home.new'),
            'counter' => getCounter($history),
        ]);

        return $next($request);
    }
}
