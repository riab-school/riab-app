@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Nama : {{ $detail->name }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-7">
                <div class="d-md-flex gap-4">
                    <div class="text-center my-2 h-50">
                        <img src="{{ $detail->studentDocument && $detail->studentDocument->photo !== NULL ? Storage::disk('s3')->url($detail->studentDocument->photo) : asset('assets/images/blank_person.jpg') }}" class="img-fluid img-thumbnail" alt="User-Profile-Image" width="180px" loading="lazy">
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table table-xs" width="100%">
                                <tr>
                                    <td class="fw-bold">NIK KTP</td>
                                    <td class="text-end">{{ $detail->nik_ktp }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tempat, Tanggal Lahir</td>
                                    <td class="text-end">{{ $detail->place_of_birth }}, {{ \Carbon\Carbon::parse($detail->date_of_birth)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Anak Ke</td>
                                    <td class="text-end"> {{ $detail->child_order }} ({{ penyebut($detail->child_order) }} ), dari {{ $detail->from_child_order }} ({{ penyebut($detail->from_child_order) }} ) Bersaudara</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Jurusan</td>
                                    <td class="text-end">{{  $detail->studentClassroom ? ($detail->studentClassroom->classroomDetail->focus == "mipa" ? "Matematika dan Ilmu Pengetahuan Alam (MIPA)" : "Ilmu Keagamaan (MAK)") : '' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Jenis Kelamin</td>
                                    <td class="text-end">{{ $detail->gender == "male" ? "Laki-Laki" : "Perempuan" }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Phone</td>
                                    <td class="text-end">{{ $detail->phone }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="table-responsive">
                    <table class="table table-xs" width="100%">
                        <tbody>
                            <tr>
                                <td class="fw-bold">NIS</td>
                                <td class="text-end">{{ $detail->nis }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">NISN</td>
                                <td class="text-end">{{ $detail->nisn }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Hobi</td>
                                <td class="text-end">{{ $detail->hobby }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Cita Cita</td>
                                <td class="text-end">{{ $detail->ambition }}</td>
                            </tr>                 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        {{-- Asal Daerah --}}
        <div class="card">
            <div class="card-header">
                <h5>Asal Daerah</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-xs" width="100%">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Kebangsaan</td>
                                <td class="text-end">{{ $detail->country == "others" ? "Warga Negara Asing (WNA)" : "Warga Negara Indonesia (WNI)" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Alamat</td>
                                <td class="text-end">{{ $detail->address }}</td>
                            </tr>
                            @if($detail->country == "idn")
                            <tr>
                                <td class="fw-bold">Provinsi</td>
                                <td class="text-end">{{ getProvince($detail->province_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kabupaten / Kota</td>
                                <td class="text-end">{{ getCity($detail->city_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kecamatan</td>
                                <td class="text-end">{{ getDistrict($detail->district_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Desa</td>
                                <td class="text-end">{{ getVillage($detail->village_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kode POS</td>
                                <td class="text-end">{{ $detail->postal_code }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Asal Sekolah --}}
        <div class="card">
            <div class="card-header">
                <h5>Asal Sekolah</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-xs" width="100%">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Nama Sekolah</td>
                                <td class="text-end">{{ $detail->studentOriginDetail ? $detail->studentOriginDetail->origin_school : '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Alamat</td>
                                <td class="text-end">{{ $detail->studentOriginDetail ? $detail->studentOriginDetail->origin_school_address : '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kategori Sekolah</td>
                                <td class="text-end">{{ $detail->studentOriginDetail ? $detail->studentOriginDetail->origin_school_category : '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nomor NPSN</td>
                                <td class="text-end">{{ $detail->studentOriginDetail ? $detail->studentOriginDetail->origin_school_npsn : '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tahun Lulus</td>
                                <td class="text-end">{{ $detail->studentOriginDetail ? $detail->studentOriginDetail->origin_school_graduate : '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Data Orang Tua --}}
        <div class="card">
            <div class="card-header">
                <h5>Data Orang Tua</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-xs" width="100%">
                        <thead>
                            <tr>
                                <th>Keterangan</th>
                                <th>Ayah</th>
                                <th>Ibu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">Nama</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->dad_name : "" }}</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->mom_name : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->dad_is_alive == true ? "Masih" : "Meninggal" : "" }}</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->mom_is_alive == true ? "Masih" : "Meninggal" : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status Pernikahan</td>
                                <td colspan="2" class="text-center">{{ $detail->studentParentDetail ? $detail->studentParentDetail->marital_status : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">No Telepon</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->dad_phone : "" }}</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->mom_phone : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pekerjaan</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->dad_occupation : "" }}</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->mom_occupation : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Penghasilan</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->dad_income : "" }}</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->mom_income : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pendidikan Terakhir</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->dad_latest_education : "" }}</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->mom_latest_education : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kebangsaan</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->dad_country == "others" ? "Warga Negara Asing (WNA)" : "Warga Negara Indonesia (WNI)" : "" }}</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->mom_country == "others" ? "Warga Negara Asing (WNA)" : "Warga Negara Indonesia (WNI)" : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Alamat</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->dad_address : "" }}</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->mom_address : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Provinsi</td>
                                <td>{{ $detail->studentParentDetail && $detail->studentParentDetail->dad_country == "idn" ? getProvince($detail->studentParentDetail->dad_province_id) : "" }}</td>
                                <td>{{ $detail->studentParentDetail && $detail->studentParentDetail->mom_country == "idn" ? getProvince($detail->studentParentDetail->mom_province_id) : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kabupaten / Kota</td>
                                <td>{{ $detail->studentParentDetail && $detail->studentParentDetail->dad_country == "idn" ? getCity($detail->studentParentDetail->dad_city_id) : "" }}</td>
                                <td>{{ $detail->studentParentDetail && $detail->studentParentDetail->mom_country == "idn" ? getCity($detail->studentParentDetail->mom_city_id) : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kecamatan</td>
                                <td>{{ $detail->studentParentDetail && $detail->studentParentDetail->dad_country == "idn" ? getDistrict($detail->studentParentDetail->dad_district_id) : "" }}</td>
                                <td>{{ $detail->studentParentDetail && $detail->studentParentDetail->mom_country == "idn" ? getDistrict($detail->studentParentDetail->mom_district_id) : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Desa</td>
                                <td>{{ $detail->studentParentDetail && $detail->studentParentDetail->dad_country == "idn" ? getVillage($detail->studentParentDetail->dad_village_id) : "" }}</td>
                                <td>{{ $detail->studentParentDetail && $detail->studentParentDetail->mom_country == "idn" ? getVillage($detail->studentParentDetail->mom_village_id) : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kode POS</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->dad_postal_code : "" }}</td>
                                <td>{{ $detail->studentParentDetail ? $detail->studentParentDetail->mom_postal_code : "" }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Data Wali --}}
        <div class="card">
            <div class="card-header">
                <h5>Data Wali Santri</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-xs" width="100%">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Nama</td>
                                <td>{{ $detail->studentGuardianDetail ? $detail->studentGuardianDetail->name : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">No Telepon</td>
                                <td>{{ $detail->studentGuardianDetail ? $detail->studentGuardianDetail->phone : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status Hubungan</td>
                                <td>{{ $detail->studentGuardianDetail ? $detail->studentGuardianDetail->relation_detail : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kebangsaan</td>
                                <td>{{ $detail->studentGuardianDetail ? $detail->studentGuardianDetail->country == "others" ? "Warga Negara Asing (WNA)" : "Warga Negara Indonesia (WNI)" : "" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Alamat</td>
                                <td>{{ $detail->studentGuardianDetail ? $detail->studentGuardianDetail->address : "" }}</td>
                            </tr>
                            @if($detail->studentGuardianDetail && $detail->studentGuardianDetail->country == "idn")
                            <tr>
                                <td class="fw-bold">Provinsi</td>
                                <td>{{ getProvince($detail->studentGuardianDetail->province_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kabupaten / Kota</td>
                                <td>{{ getCity($detail->studentGuardianDetail->city_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kecamatan</td>
                                <td>{{ getDistrict($detail->studentGuardianDetail->district_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Desa</td>
                                <td>{{ getVillage($detail->studentGuardianDetail->village_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kode POS</td>
                                <td>{{ $detail->studentGuardianDetail->postal_code }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        {{-- Rapor Sisswa --}}
        <div class="card">
            <div class="card-header">
                <h5>Rapor Siswa</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm" width="100%">
                        <tr>
                            <td class="fw-bold">Kelas VII (Semester 1)</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->report_1_1 !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->report_1_1) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kelas VII (Semester 2)</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->report_1_2 !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->report_1_2) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kelas VIII (Semester 1)</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->report_2_1 !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->report_2_1) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kelas VIII (Semester 2)</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->report_2_2 !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->report_2_2) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Berkas Pendukung Siswa</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm" width="100%">
                        <tr>
                            <td class="fw-bold">Rekomendasi Kepala Sekolah</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->origin_head_recommendation !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->origin_head_recommendation) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Keterangan Rangking</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->certificate_of_letter !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->certificate_of_letter) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Surat Keterangan Sehat</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->certificate_of_health !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->certificate_of_health) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="button-group text-center">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-check"></i> Approve & Verifikasi
            </a>
            <a href="#" class="btn btn-danger">
                <i class="fas fa-times"></i> Tolak Berkas
            </a>
        </div>
        {{-- Berkas Kelengkapan --}}
        {{-- <div class="card">
            <div class="card-header">
                <h5>Berkas Lainnya</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm" width="100%">
                        <tr>
                            <td class="fw-bold">KTP Siswa</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->ktp_file !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->ktp_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kartu Keluarga</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->kk_file !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->kk_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Akte Kelahiran</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->akte_file !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->akte_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kartu  NISN</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->nisn_file !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->nisn_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kartu Siswa</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->nis_file !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->nis_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">KTP Ayah</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->dad_ktp_file !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->dad_ktp_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">KTP Ibu</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->mom_ktp_file !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->mom_ktp_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">KTP Wali</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->guardian_ktp_file !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->guardian_ktp_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kartu BPJS</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->bpjs !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->bpjs) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kartu Indonesia Sehat (KIS)</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->kis !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->kis) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kartu Indonesia Pintar (KIP)</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->kip !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->kip) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Sertifkat Vaksin 1</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->vaccine_certificate_1 !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->vaccine_certificate_1) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Sertifkat Vaksin 2</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->vaccine_certificate_2 !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->vaccine_certificate_2) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Sertifkat Vaksin 3</td>
                            <td class="text-end">
                                @if($detail->studentDocument && $detail->studentDocument->vaccine_certificate_3 !== NULL)
                                    <a href="{{ Storage::disk('s3')->url($detail->studentDocument->vaccine_certificate_3) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Upload File</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> --}}
    </div>

</div>

@endsection