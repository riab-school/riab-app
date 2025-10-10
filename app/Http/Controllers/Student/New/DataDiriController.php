<?php

namespace App\Http\Controllers\Student\New;

use App\Http\Controllers\Controller;
use App\Models\PsbDocumentRejection;
use App\Models\StudentDetail;
use App\Models\StudentsAchievement;
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
                return view('app.student.new.data-diri.page-1');
                break;
            case '2':
                return view('app.student.new.data-diri.page-2');
                break;
            case '3':
                return view('app.student.new.data-diri.page-3');
                break;
            case '4':
                return view('app.student.new.data-diri.page-4');
                break;
            case '5':
                return view('app.student.new.data-diri.page-5');
                break;
            case '6':
                return view('app.student.new.data-diri.page-6');
            default:
                return view('app.student.new.data-diri.page-1');
                break;
        }
        return view('student.new.data-diri.index');
    }

    public function handleStorePage1(Request $request)
    {
        //check if student detail is completed
        $studentDetail = StudentDetail::where('user_id', auth()->user()->id)->first();
        if ($studentDetail && $studentDetail->is_completed) {
            return redirect()->back()->withInput()->with([
                'status'    => 'error',
                'message'   => 'Data diri sudah diverifikasi, tidak dapat diubah kembali. Hubungi admin atau panitia untuk bantuan lebih lanjut.',
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
                'message'   => 'Data diri sudah diverifikasi, tidak dapat diubah kembali. Hubungi admin atau panitia untuk bantuan lebih lanjut.',
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
                'message' => 'Data orang tua sudah diverifikasi, tidak dapat diubah kembali. Hubungi admin atau panitia untuk bantuan lebih lanjut.',
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
            'dad_postal_code'       => 'nullable|string|max:10',
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
            'mom_postal_code'       => 'nullable|string|max:10',
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
                'message' => 'Data wali sudah diverifikasi, tidak dapat diubah kembali. Hubungi admin atau panitia untuk bantuan lebih lanjut.',
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
        $StudentDocument = StudentsDocument::where('user_id', auth()->id())->first();
        $StudentDocumentRejected = PsbDocumentRejection::where('user_id', auth()->id())->get();

        // Cek kalau sudah complete tidak boleh update lagi
        if ($StudentDocument && $StudentDocument->is_completed) {
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => 'Dokument anda sudah diverifikasi, tidak dapat diubah kembali. Hubungi admin atau panitia untuk bantuan lebih lanjut.',
            ]);
        }

        try {
            $request->validate([
                'photo' => [
                    getRejectedFile('photo') || auth()->user()->myDetail->studentDocument->photo == NULL
                        ? 'required'
                        : 'nullable',
                    'image',
                    'mimes:jpeg,png,jpg',
                    'max:1024',
                ],
                'certificate_of_letter' => [
                    'mimes:pdf',
                    'max:2048',
                ],
                'origin_head_recommendation' => [
                    getRejectedFile('origin_head_recommendation') || auth()->user()->myDetail->studentDocument->origin_head_recommendation == NULL
                        ? 'required'
                        : 'nullable',
                    'mimes:pdf',
                    'max:2048',
                ],
                'certificate_of_health' => [
                    getRejectedFile('certificate_of_health') || auth()->user()->myDetail->studentDocument->certificate_of_health == NULL
                        ? 'required'
                        : 'nullable',
                    'mimes:pdf',
                    'max:2048',
                ],
                'report_1_1' => [
                    getRejectedFile('report_1_1') || auth()->user()->myDetail->studentDocument->report_1_1 == NULL
                        ? 'required'
                        : 'nullable',
                    'mimes:pdf',
                    'max:2048',
                ],
                'report_1_2' => [
                    getRejectedFile('report_1_2') || auth()->user()->myDetail->studentDocument->report_1_2 == NULL
                        ? 'required'
                        : 'nullable',
                    'mimes:pdf',
                    'max:2048',
                ],
                'report_2_1' => [
                    getRejectedFile('report_2_1') || auth()->user()->myDetail->studentDocument->report_2_1 == NULL
                        ? 'required'
                        : 'nullable',
                    'mimes:pdf',
                    'max:2048',
                ],
                'report_2_2' => [
                    getRejectedFile('report_2_2') || auth()->user()->myDetail->studentDocument->report_2_2 == NULL
                        ? 'required'
                        : 'nullable',
                    'mimes:pdf',
                    'max:2048',
                ],
            ]);


            $fileFields = [
                'photo', 'certificate_of_letter', 'origin_head_recommendation', 'certificate_of_health',
                'report_1_1', 'report_1_2', 'report_2_1', 'report_2_2'
            ];

            // kalau StudentDocument belum ada, buat baru
            if (!$StudentDocument) {
                $StudentDocument = new StudentsDocument();
                $StudentDocument->user_id = auth()->id();
            }

            // Kalau ada $StudentDocumentRejected maka update semuanya berdasarkan user_id itu menjadi resolved
            if ($StudentDocumentRejected && $StudentDocumentRejected->count() > 0) {
                foreach ($StudentDocumentRejected as $rejected) {
                    $rejected->status = 'resolved';
                    $rejected->save();
                }
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

    public function handleStorePage6(Request $request)
    {
        // Cek kalau sudah complete tidak boleh update lagi
        $StudentDocument = StudentsDocument::where('user_id', auth()->id())->first();
        if ($StudentDocument && $StudentDocument->is_completed) {
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => 'Dokumen anda sudah diverifikasi, tidak dapat diubah kembali. Hubungi admin atau panitia untuk bantuan lebih lanjut.',
            ]);
        }

        try {
            $request->validate([
                'evidence.*' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:1024'],
                'detail.*'   => ['required', 'string', 'max:255'],
            ]);

            foreach ($request->detail as $index => $detail) {
                if (empty($detail)) continue;

                $achievementId = $request->id[$index] ?? null;

                // cari existing, kalau gak ada buat baru langsung
                $achievement = StudentsAchievement::where('user_id', auth()->id())
                    ->where('id', $achievementId)
                    ->first() ?? new StudentsAchievement();

                // pastikan user_id selalu terisi
                $achievement->user_id = auth()->id();

                $achievement->detail  = $detail;
                $achievement->action_taked = '-';
                $achievement->process_by = auth()->id();
                $achievement->is_notify_parent = false;

                // kalau ada file baru, upload dan hapus lama
                if ($request->hasFile("evidence.$index")) {
                    // hapus file lama di s3
                    if ($achievement->evidence) {
                        Storage::disk('s3')->delete($achievement->evidence);
                    }

                    $file     = $request->file("evidence.$index");
                    $folder   = "student/" . auth()->id() . "/achievements";
                    $filename = "evidence_" . time() . "_$index." . $file->getClientOriginalExtension();
                    $fullPath = $folder . '/' . $filename;

                    Storage::disk('s3')->put($fullPath, file_get_contents($file));
                    $achievement->evidence = $fullPath;
                }

                $achievement->save();
            }


            appLog(auth()->id(), 'success', 'Berhasil upload sertifikat atau penghargaan');
            return redirect()->back()->with([
                'status'  => 'success',
                'message' => 'Data sertifikat berhasil diperbarui',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->id(), 'error', 'Gagal upload sertifikat atau penghargaan', $th->getMessage());
            return redirect()->back()->withInput()->with([
                'status'  => 'error',
                'message' => $th->getMessage(),
            ]);
        }


    }

    public function handleDeleteCertificate(Request $request)
    {
        try {
            $achievement = StudentsAchievement::where('id', $request->id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$achievement) {
                return redirect()->back()->with([
                    'status' => 'error',
                    'message' => 'Data sertifikat tidak ditemukan.',
                ]);
            }

            // Hapus file di S3
            if ($achievement->evidence && Storage::disk('s3')->exists($achievement->evidence)) {
                Storage::disk('s3')->delete($achievement->evidence);
            }

            // Hapus record
            $achievement->delete();

            appLog(auth()->id(), 'success', 'Berhasil menghapus sertifikat prestasi');
            return response()->json([
                'status' => 'success',
                'message' => 'Sertifikat berhasil dihapus.',
            ]);

        } catch (\Throwable $th) {
            appLog(auth()->id(), 'error', 'Gagal menghapus sertifikat', $th->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

}
