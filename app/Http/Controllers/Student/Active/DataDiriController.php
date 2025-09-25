<?php

namespace App\Http\Controllers\Student\Active;

use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
use App\Models\StudentsDocument;
use App\Models\StudentsGuardianDetail;
use App\Models\StudentsHealth;
use App\Models\StudentsOriginSchool;
use App\Models\StudentsParentDetail;
use Illuminate\Http\Request;
use Storage;

class DataDiriController extends Controller
{
    public function index(Request $request)
    {
        switch ($request->page) {
            case '1':
                return view('app.student.active.data-diri.page-1');
                break;
            case '2':
                return view('app.student.active.data-diri.page-2');
                break;
            case '3':
                return view('app.student.active.data-diri.page-3');
                break;
            case '4':
                return view('app.student.active.data-diri.page-4');
                break;
            case '5':
                return view('app.student.active.data-diri.page-5');
                break;
            case '6':
                return view('app.student.active.data-diri.page-6');
                break;
            default:
                return view('app.student.active.data-diri.page-1');
                break;
        }
        return view('student.active.data-diri.index');
    }

    public function handleStorePage1(Request $request)
    {
        //check if student detail is completed
        $studentDetail = StudentDetail::where('user_id', auth()->user()->id)->first();
        if ($studentDetail && $studentDetail->is_completed) {
            return redirect()->back()->withInput()->with([
                'status'    => 'error',
                'message'   => 'Data diri sudah lengkap, tidak dapat diubah kembali. Hubungi admin atau pembina untuk bantuan lebih lanjut.',
            ]);
        }

        // Validate the request
        $request->validate([
            'name'              => 'required|string|max:255',
            'nik_ktp'           => 'nullable|string|max:17|unique:student_details,nik_ktp,' . auth()->user()->id . ',user_id',
            'nik_kk'            => 'nullable|string|max:17',
            'akte_number'       => 'nullable|string|max:255',
            'nisn'              => 'nullable|string|max:255|unique:student_details,nisn,' . auth()->user()->id . ',user_id',
            'place_of_birth'    => 'required|string|max:255',
            'date_of_birth'     => 'required|date',
            'gender'            => 'required|string|max:10',
            'phone'             => 'required|string|max:15',
            'country'           => 'required|string|in:idn,others',
            'address'           => 'required|string|max:255',
            'province_id'       => 'required_if:country,idn|integer',
            'city_id'           => 'required_if:country,idn|integer',
            'district_id'       => 'required_if:country,idn|integer',
            'village_id'        => 'required_if:country,idn|integer',
            'postal_code'       => 'required_if:country,idn|string|max:10',
            'child_order'       => 'required|integer|min:1',
            'from_child_order'  => 'required|integer|min:1',
            'hobby'             => 'required|string|max:100',
            'ambition'          => 'required|string|max:100',
        ]);

        try {
            StudentDetail::where('user_id', auth()->user()->id)->update(
                [
                    'name'              => $request->name,
                    'nik_ktp'           => $request->nik_ktp,
                    'nik_kk'            => $request->nik_kk,
                    'akte_number'       => $request->akte_number,
                    'nisn'              => $request->nisn,
                    'place_of_birth'    => $request->place_of_birth,
                    'date_of_birth'     => $request->date_of_birth,
                    'gender'            => $request->gender,
                    'phone'             => $request->phone,
                    'country'           => $request->country,
                    'address'           => $request->address,
                    'province_id'       => $request->province_id ?? null,
                    'city_id'           => $request->city_id ?? null,
                    'district_id'       => $request->district_id ?? null,
                    'village_id'        => $request->village_id ?? null,
                    'postal_code'       => $request->postal_code ?? null,
                    'child_order'       => $request->child_order ?? null,
                    'from_child_order'  => $request->from_child_order,
                    'hobby'             => $request->hobby,
                    'ambition'          => $request->ambition,
                    'is_completed'      => true,
                ]
            );
    
            appLog(auth()->user()->id, 'success', 'Berhasil update data diri');
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Data berhasil diperbarui',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal update data diri', $th->getMessage());
            return redirect()->back()->withInput()->with([
                'status'    => 'error',
                'message'   => 'Terjadi kesalahan saat memperbarui data',
            ]);
        }
    }

    public function handleStorePage2(Request $request)
    {
        //check if student detail is completed
        $studentDetail = StudentsOriginSchool::where('user_id', auth()->user()->id)->first();
        if ($studentDetail && $studentDetail->is_completed) {
            return redirect()->back()->withInput()->with([
                'status'    => 'error',
                'message'   => 'Data diri sudah lengkap, tidak dapat diubah kembali. Hubungi admin atau pembina untuk bantuan lebih lanjut.',
            ]);
        }

        $request->validate([
            'origin_school'         => 'required|string|max:255',
            'origin_school_address' => 'required|string|max:255',
            'origin_school_category'=> 'required|string|in:negeri,swasta',
            'origin_school_npsn'    => 'nullable|string|digits_between:8,12|numeric',
            'origin_school_graduate'=> 'required|integer|min:1900|max:' . date('Y'),
        ]);

        try {
            StudentsOriginSchool::updateOrCreate(
                [
                    'user_id' => auth()->user()->id,
                ],
                [
                    'origin_school'         => $request->origin_school,
                    'origin_school_address' => $request->origin_school_address,
                    'origin_school_category'=> $request->origin_school_category,
                    'origin_school_npsn'    => $request->origin_school_npsn,
                    'origin_school_graduate'=> $request->origin_school_graduate,
                    'is_completed'          => true,
                ]
            );
            appLog(auth()->user()->id, 'success', 'Berhasil update data asal sekolah');
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Data asal sekolah berhasil diperbarui',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal update data asal sekolah', $th->getMessage());
            return redirect()->back()->withInput()->with([
                'status'    => 'error',
                'message'   => 'Terjadi kesalahan saat memperbarui data asal sekolah',
            ]);
        }

    }

    public function handleStorePage3(Request $request)
    {
        $studentParent = StudentsParentDetail::where('user_id', auth()->id())->first();

        // Cek kalau sudah complete tidak boleh update lagi
        if ($studentParent && $studentParent->is_completed) {
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => 'Data orang tua sudah lengkap, tidak dapat diubah kembali. Hubungi admin atau pembina untuk bantuan lebih lanjut.',
            ]);
        }

        // Validasi
        $request->validate([
            // Ayah
            'dad_name'              => 'required|string|max:255',
            'dad_nik_ktp'           => 'nullable|string|max:17',
            'dad_phone'             => 'nullable|string|max:15',
            'dad_latest_education'  => 'nullable|string|max:100',
            'dad_occupation'        => 'nullable|string|max:100',
            'dad_income'            => 'nullable|string|max:100',
            'dad_country'           => 'required|string|in:idn,others',
            'dad_address'           => 'required|string|max:255',
            'dad_province_id'       => 'required_if:dad_country,idn|integer',
            'dad_city_id'           => 'required_if:dad_country,idn|integer',
            'dad_district_id'       => 'required_if:dad_country,idn|integer',
            'dad_village_id'        => 'required_if:dad_country,idn|integer',
            'dad_postal_code'       => 'required_if:dad_country,idn|string|max:10',
            'dad_is_alive'          => 'required|boolean',
            'status_with_dad'       => 'required|string|in:biological,step,adopted',

            // Ibu
            'mom_name'              => 'required|string|max:255',
            'mom_nik_ktp'           => 'nullable|string|max:17',
            'mom_phone'             => 'nullable|string|max:15',
            'mom_latest_education'  => 'nullable|string|max:100',
            'mom_occupation'        => 'nullable|string|max:100',
            'mom_income'            => 'nullable|string|max:100',
            'mom_country'           => 'required|string|in:idn,others',
            'mom_address'           => 'required|string|max:255',
            'mom_province_id'       => 'required_if:mom_country,idn|integer',
            'mom_city_id'           => 'required_if:mom_country,idn|integer',
            'mom_district_id'       => 'required_if:mom_country,idn|integer',
            'mom_village_id'        => 'required_if:mom_country,idn|integer',
            'mom_postal_code'       => 'required_if:mom_country,idn|string|max:10',
            'mom_is_alive'          => 'required|boolean',
            'status_with_mom'       => 'required|string|in:biological,step,adopted',

            // Status keluarga
            'marital_status'        => 'required|string|in:married,divorce,dead-divorce',
        ]);

        try {
            StudentsParentDetail::updateOrCreate(
                [
                    'user_id' => auth()->user()->id,
                ],
                [
                    // Ayah
                    'dad_name'              => $request->dad_name,
                    'dad_nik_ktp'           => $request->dad_nik_ktp,
                    'dad_phone'             => $request->dad_phone,
                    'dad_latest_education'  => $request->dad_latest_education,
                    'dad_occupation'        => $request->dad_occupation,
                    'dad_income'            => $request->dad_income,
                    'dad_country'           => $request->dad_country,
                    'dad_address'           => $request->dad_address,
                    'dad_province_id'       => $request->dad_province_id,
                    'dad_city_id'           => $request->dad_city_id,
                    'dad_district_id'       => $request->dad_district_id,
                    'dad_village_id'        => $request->dad_village_id,
                    'dad_postal_code'       => $request->dad_postal_code,
                    'dad_is_alive'          => $request->dad_is_alive,
                    'status_with_dad'       => $request->status_with_dad,

                    // Ibu
                    'mom_name'              => $request->mom_name,
                    'mom_nik_ktp'           => $request->mom_nik_ktp,
                    'mom_phone'             => $request->mom_phone,
                    'mom_latest_education'  => $request->mom_latest_education,
                    'mom_occupation'        => $request->mom_occupation,
                    'mom_income'            => $request->mom_income,
                    'mom_country'           => $request->mom_country,
                    'mom_address'           => $request->mom_address,
                    'mom_province_id'       => $request->mom_province_id,
                    'mom_city_id'           => $request->mom_city_id,
                    'mom_district_id'       => $request->mom_district_id,
                    'mom_village_id'        => $request->mom_village_id,
                    'mom_postal_code'       => $request->mom_postal_code,
                    'mom_is_alive'          => $request->mom_is_alive,
                    'status_with_mom'       => $request->status_with_mom,

                    // Status keluarga
                    'marital_status'        => $request->marital_status,
                    'is_completed'          => true,
                ]
            );

            appLog(auth()->id(), 'success', 'Berhasil update data orang tua');
            return redirect()->back()->with([
                'status'  => 'success',
                'message' => 'Data orang tua berhasil diperbarui',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->id(), 'error', 'Gagal update data orang tua', $th->getMessage());
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data orang tua',
            ]);
        }
    }

    public function handleStorePage4(Request $request)
    {
        $studentGuardian = StudentsGuardianDetail::where('user_id', auth()->id())->first();

        // Cek kalau sudah complete tidak boleh update lagi
        if ($studentGuardian && $studentGuardian->is_completed) {
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => 'Data wali sudah lengkap, tidak dapat diubah kembali. Hubungi admin atau pembina untuk bantuan lebih lanjut.',
            ]);
        }
        
        // Validasi
        $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|max:15',
            'country'       => 'required|string|in:idn,others',
            'address'       => 'required|string|max:255',
            'province_id'   => 'required_if:country,idn|integer',
            'city_id'       => 'required_if:country,idn|integer',
            'district_id'   => 'required_if:country,idn|integer',
            'village_id'    => 'required_if:country,idn|integer',
            'postal_code'   => 'required_if:country,idn|string|max:10',
            'relation_detail'=> 'required|string|max:100',
        ]);

        try {
            StudentsGuardianDetail::updateOrCreate(
                [
                    'user_id' => auth()->user()->id,
                ],
                [
                    'name'          => $request->name,
                    'phone'         => $request->phone,
                    'country'       => $request->country,
                    'address'       => $request->address,
                    'province_id'   => $request->province_id,
                    'city_id'       => $request->city_id,
                    'district_id'   => $request->district_id,
                    'village_id'    => $request->village_id,
                    'postal_code'   => $request->postal_code,
                    'relation_detail'=> $request->relation_detail,
                    'is_completed'  => true,
                ]
            );

            appLog(auth()->id(), 'success', 'Berhasil update data wali');
            return redirect()->back()->with([
                'status'  => 'success',
                'message' => 'Data wali berhasil diperbarui',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->id(), 'error', 'Gagal update data wali', $th->getMessage());
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data wali',
            ]);
        }
    }

    public function handleStorePage5(Request $request)
    {
        $studentHealth = StudentsHealth::where('user_id', auth()->id())->first();

        // Cek kalau sudah complete tidak boleh update lagi
        if ($studentHealth && $studentHealth->is_completed) {
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => 'Data wali sudah lengkap, tidak dapat diubah kembali. Hubungi admin atau pembina untuk bantuan lebih lanjut.',
            ]);
        }

        try {
            $request->validate([
                'blood'             => 'required|string|in:A+,B+,AB+,O+,A-,B-,AB-,O-',
                'food_alergic'      => 'nullable|string|max:255',
                'drug_alergic'      => 'nullable|string|max:255',
                'other_alergic'     => 'nullable|string|max:255',
                'disease_history'   => 'nullable|string|max:500',
                'disease_ongoing'   => 'nullable|string|max:500',
                'drug_consumption'  => 'nullable|string|max:500',
                'weight'            => 'nullable|numeric|min:1|max:300',
                'height'            => 'nullable|numeric|min:30|max:250',
            ]);

            StudentsHealth::updateOrCreate(
                [
                    'user_id' => auth()->user()->id,
                ],
                [
                    'blood'             => $request->blood,
                    'food_alergic'      => $request->food_alergic,
                    'drug_alergic'      => $request->drug_alergic,
                    'other_alergic'     => $request->other_alergic,
                    'disease_history'   => $request->disease_history,
                    'disease_ongoing'   => $request->disease_ongoing,
                    'drug_consumption'  => $request->drug_consumption,
                    'weight'            => $request->weight,
                    'height'            => $request->height,
                    'is_completed'      => true,
                ]
            );

            appLog(auth()->id(), 'success', 'Berhasil update data kesehatan');
            return redirect()->back()->with([
                'status'  => 'success',
                'message' => 'Data kesehatan berhasil diperbarui',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->id(), 'error', 'Gagal update data kesehatan', $th->getMessage());
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data kesehatan',
            ]);
        }
    }

    public function handleStorePage6(Request $request)
    {
        $StudentDocument = StudentsDocument::where('user_id', auth()->id())->first();

        // Cek kalau sudah complete tidak boleh update lagi
        if ($StudentDocument && $StudentDocument->is_completed) {
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => 'Dokument anda sudah lengkap, tidak dapat diubah kembali. Hubungi admin atau pembina untuk bantuan lebih lanjut.',
            ]);
        }

        try {
            $request->validate([
                'photo'             => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'ktp_file'          => 'required|mimes:jpeg,png,jpg|max:2048',
                'kk_file'           => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
                'akte_file'         => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
                'nisn_file'         => 'required|mimes:jpeg,png,jpg|max:2048',
                'dad_ktp_file'      => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'mom_ktp_file'      => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'guardian_ktp_file' => 'required|mimes:jpeg,png,jpg|max:2048',
                'bpjs'              => 'required|mimes:jpeg,png,jpg|max:2048',
                'kis'               => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'kip'               => 'nullable|mimes:jpeg,png,jpg|max:2048',
            ]);

            $fileFields = [
                'photo', 'ktp_file', 'kk_file', 'akte_file', 'nisn_file',
                'dad_ktp_file', 'mom_ktp_file', 'guardian_ktp_file',
                'bpjs', 'kis', 'kip'
            ];

            // kalau StudentDocument belum ada, buat baru
            if (!$StudentDocument) {
                $StudentDocument = new StudentsDocument();
                $StudentDocument->user_id = auth()->id();
            }

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file     = $request->file($field);
                    $folder   = "student/" . auth()->id() . "/" . $field;
                    $filename = auth()->id() . "." . $file->getClientOriginalExtension();
                    $fullPath = $folder . '/' . $filename;

                    // simpan ke s3
                    Storage::disk('s3')->put($fullPath, file_get_contents($file));

                    // simpan path ke field database sesuai nama field
                    $StudentDocument->{$field} = $fullPath;

                    // Hapus file lama jika ada dan berbeda
                    if ($StudentDocument->getOriginal($field) && $StudentDocument->getOriginal($field) !== $fullPath) {
                        Storage::disk('s3')->delete($StudentDocument->getOriginal($field));
                    }
                }
            }
            $StudentDocument->is_completed = true;
            $StudentDocument->save();

            appLog(auth()->id(), 'success', 'Berhasil upload dokumen atau berkas');
            return redirect()->back()->with([
                'status'  => 'success',
                'message' => 'Data dokumen atau berkas berhasil diperbarui',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->id(), 'error', 'Gagal upload berkas atau dokument', $th->getMessage());
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
