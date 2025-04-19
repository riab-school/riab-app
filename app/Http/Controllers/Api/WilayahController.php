<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function getAllProvince(Request $request)
    {
        $data = Province::all();
        return response()->json($data, 200);
    }

    public function getCity(Request $request)
    {
        if ($request->has('province_id')) {
            $data = City::where('province_id', $request->province_id)->get();
        } else if ($request->has('id')) {
            $data = City::where('id', $request->id)->get();
        }
        return response()->json($data, 200);
    }

    public function getDistrict(Request $request)
    {
        if ($request->has('city_id')) {
            $data = District::where('city_id', $request->city_id)->get();
        } else if ($request->has('id')) {
            $data = District::where('id', $request->id)->get();
        }
        return response()->json($data, 200);
    }

    public function getVillage(Request $request)
    {
        if ($request->has('district_id')) {
            $data = Village::where('district_id', $request->district_id)->get();
        } else if ($request->has('id')) {
            $data = Village::where('id', $request->id)->get();
        }
        return response()->json($data, 200);
    }
}
