<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function showPage()
    {
        return view('app.parent.berita');
    }

    public function getBerita(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->get('page', 1);
    
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => appSet('SCHOOL_WEBSITE')."/wp-json/wp/v2/posts?per_page=6&page=$page&_embed",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
    
            if ($err) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error retrieving data'
                ]);
            } else {
                $data = json_decode($response, true);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data retrieved successfully',
                    'blog' => $data,
                    'next_page' => count($data) === 6 ? $page + 1 : null // kalau hasil < 6, berarti sudah akhir
                ]);
            }
        }
    }
}
