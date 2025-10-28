@extends('_layouts.app-layouts.index')

@section('content')

{{-- Data Pribadi --}}
<div class="card">
    <div class="card-header">
        <h5>Data Pribadi
            @if ($detail->is_completed)
                <span class="badge bg-success">Completed</span>
            @elseif($detail->is_rejected !== null && $detail->is_rejected)
                <span class="badge bg-danger">Rejected</span>
            @else
                <span class="badge bg-warning">Pending</span>
            @endif
        </h5>
        <div class="card-header-right btn-group">
            <button class="btn btn-success Approve" data-approve="student_details">Approve</button>
            <button class="btn btn-danger Reject" data-reject="student_details">Reject</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="d-md-flex gap-4">
                    <div class="text-center my-2 h-50">
                        <img src="{{ $detail->studentDocument && $detail->studentDocument->photo !== NULL ? Storage::disk('s3')->url($detail->studentDocument->photo) : asset('assets/images/blank_person.jpg') }}" class="img-fluid img-thumbnail" alt="User-Profile-Image" width="180px" loading="lazy">
                        <a href="{{ route('staff.master-psb.student-detail.login-as') }}?user_id={{ $detail->user_id }}" onclick="confirm('Apakaha anda ingin login sebagai {{ $detail->name }} ?')" class="btn btn-primary btn-sm mt-2">Login Sebagai Siswa</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-xs" width="100%">
                            <tr class="fs-4">
                                <td class="fw-bold">Nama Siswa</td>
                                <td>{{ $detail->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">NIK KTP</td>
                                <td>{{ $detail->nik_ktp }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tempat, Tanggal Lahir</td>
                                <td>{{ $detail->place_of_birth }}, {{ \Carbon\Carbon::parse($detail->date_of_birth)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Anak Ke</td>
                                <td> {{ $detail->child_order }} ({{ penyebut($detail->child_order) }} ), dari {{ $detail->from_child_order }} ({{ penyebut($detail->from_child_order) }} ) Bersaudara</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Jurusan</td>
                                <td>{{  $detail->studentClassroom ? ($detail->studentClassroom->classroomDetail->focus == "mipa" ? "Matematika dan Ilmu Pengetahuan Alam (MIPA)" : "Ilmu Keagamaan (MAK)") : '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Jenis Kelamin</td>
                                <td>{{ $detail->gender == "male" ? "Laki-Laki" : "Perempuan" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Phone</td>
                                <td>{{ $detail->phone }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">NISN</td>
                                <td>{{ $detail->nisn }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Hobi</td>
                                <td>{{ $detail->hobby }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Cita Cita</td>
                                <td>{{ $detail->ambition }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kebangsaan</td>
                                <td>{{ $detail->country == "others" ? "Warga Negara Asing (WNA)" : "Warga Negara Indonesia (WNI)" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Alamat</td>
                                <td>{{ $detail->address }}</td>
                            </tr>
                            @if($detail->country == "idn")
                            <tr>
                                <td class="fw-bold">Provinsi</td>
                                <td>{{ getProvince($detail->province_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kabupaten / Kota</td>
                                <td>{{ getCity($detail->city_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kecamatan</td>
                                <td>{{ getDistrict($detail->district_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Desa</td>
                                <td>{{ getVillage($detail->village_id) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kode POS</td>
                                <td>{{ $detail->postal_code }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Asal Sekolah --}}
<div class="card">
    <div class="card-header">
        <h5>Asal Sekolah
            @if ($detail->studentOriginDetail && $detail->studentOriginDetail->is_completed)
                <span class="badge bg-success">Completed</span>
            @elseif($detail->studentOriginDetail && $detail->studentOriginDetail->is_rejected !== null && $detail->studentOriginDetail->is_rejected)
                <span class="badge bg-danger">Rejected</span>
            @else
                <span class="badge bg-warning">Pending</span>
            @endif
        </h5>
        <div class="card-header-right btn-group">
            <button class="btn btn-success Approve" data-approve="students_origin_schools">Approve</button>
            <button class="btn btn-danger Reject" data-reject="students_origin_schools">Reject</button>
        </div>
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
        <h5>Data Orang Tua
            @if ($detail->studentParentDetail && $detail->studentParentDetail->is_completed)
                <span class="badge bg-success">Completed</span>
            @elseif($detail->studentParentDetail && $detail->studentParentDetail->is_rejected !== null && $detail->studentParentDetail->is_rejected)
                <span class="badge bg-danger">Rejected</span>
            @else
                <span class="badge bg-warning">Pending</span>
            @endif
        </h5>
        <div class="card-header-right btn-group">
            <button class="btn btn-success Approve" data-approve="students_parent_details">Approve</button>
            <button class="btn btn-danger Reject" data-reject="students_parent_details">Reject</button>
        </div>
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
        <h5>Data Wali Santri
            @if ($detail->studentGuardianDetail && $detail->studentGuardianDetail->is_completed)
                <span class="badge bg-success">Completed</span>
            @elseif($detail->studentGuardianDetail && $detail->studentGuardianDetail->is_rejected !== null && $detail->studentGuardianDetail->is_rejected)
                <span class="badge bg-danger">Rejected</span>
            @else
                <span class="badge bg-warning">Pending</span>
            @endif
        </h5>
        <div class="card-header-right btn-group">
            <button class="btn btn-success Approve" data-approve="students_guardian_details">Approve</button>
            <button class="btn btn-danger Reject" data-reject="students_guardian_details">Reject</button>
        </div>
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

{{-- Rapor Siswa --}}
<div class="card">
    <div class="card-header">
        <h5>Rapor Siswa dan Berkas
            @if ($detail->studentDocument && $detail->studentDocument->is_completed)
                <span class="badge bg-success">Completed</span>
            @else
                <span class="badge bg-warning">Pending</span>
            @endif
        </h5>
        <div class="card-header-right btn-group">
            <button class="btn btn-success Approve" data-approve="students_documents">Approve</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm" width="100%">
                <tr>
                    <td class="fw-bold">Kelas VII (Semester 1)</td>
                    <td class="text-end">
                        @if($detail->studentDocument && $detail->studentDocument->report_1_1 !== NULL)
                            <a href="{{ Storage::disk('s3')->url($detail->studentDocument->report_1_1) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                            <button class="btn btn-danger btn-sm RejectItem" data-reject-item="report_1_1">Reject</button>
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
                            <button class="btn btn-danger btn-sm RejectItem" data-reject-item="report_1_2">Reject</button>
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
                            <button class="btn btn-danger btn-sm RejectItem" data-reject-item="report_2_1">Reject</button>
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
                            <button class="btn btn-danger btn-sm RejectItem" data-reject-item="report_2_2">Reject</button>
                        @else
                            <span class="text-danger">Tidak Upload File</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Rekomendasi Kepala Sekolah</td>
                    <td class="text-end">
                        @if($detail->studentDocument && $detail->studentDocument->origin_head_recommendation !== NULL)
                            <a href="{{ Storage::disk('s3')->url($detail->studentDocument->origin_head_recommendation) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                            <button class="btn btn-danger btn-sm RejectItem" data-reject-item="origin_head_recommendation">Reject</button>
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
                            <button class="btn btn-danger btn-sm RejectItem" data-reject-item="certificate_of_letter">Reject</button>
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
                            <button class="btn btn-danger btn-sm RejectItem" data-reject-item="certificate_of_health">Reject</button>
                        @else
                            <span class="text-danger">Tidak Upload File</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

{{-- Prestasi --}}
<div class="card">
    <div class="card-header">
        <h5>Sertifikat dan Prestasi</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm" width="100%">
                @forelse($detail->studentAchievementHistory as $achievement)
                <tr>
                    <td class="fw-bold">{{ $achievement->detail }}</td>
                    <td class="text-end">
                        @if($achievement->evidence !== NULL)
                            <a href="{{ Storage::disk('s3')->url($achievement->evidence) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                        @else
                            <span class="text-danger">Tidak Upload File</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">Tidak ada data prestasi</td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>
</div>

{{-- BTN FINAL --}}
<div class="d-flex justify-content-center">
    <form action="{{ route('staff.master-psb.student-detail.handle-seleksi-adm') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin meluluskan seleksi administrasi untuk siswa ini?');">
        @csrf
        <input type="hidden" name="user_id" id="user_id" value="{{ $detail->user_id }}">
        <input type="hidden" name="action" id="action" value="approve">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Luluskan Seleksi ADM
        </button>
    </form>
    <form action="{{ route('staff.master-psb.student-detail.handle-seleksi-adm') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak seleksi administrasi untuk siswa ini?');">
        @csrf
        <input type="hidden" name="user_id" id="user_id" value="{{ $detail->user_id }}">
        <input type="hidden" name="action" id="action" value="reject">
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-times"></i> Tolak Seleksi ADM
        </button>
    </form>
</div>

@endsection

@push('scripts')
    <script>
        $('.Approve').on('click', function() {
            let approveType = $(this).data('approve');
            handleApprovalRejection(approveType, 'approve');
        });

        $('.Reject').on('click', function() {
            let rejectType = $(this).data('reject');
            handleApprovalRejection(rejectType, 'reject');
        });

        $('.RejectItem').on('click', function() {
            let rejectTypeItem = $(this).data('reject-item');
            handleApprovalRejection(rejectTypeItem, 'reject_item');
        });

        handleApprovalRejection = (type, action) => {
            let reason = '';
            if(action === 'reject') {
                reason = prompt('Masukkan alasan penolakan:');
                if(reason === null || reason.trim() === '') {
                    alert('Alasan penolakan wajib diisi.');
                    return;
                }
            }

            if(action === 'reject_item') {
                reason = prompt('Masukkan alasan penolakan:');
                if(reason === null || reason.trim() === '') {
                    alert('Alasan penolakan wajib diisi.');
                    return;
                }
            }

            $.ajax({
                url: '{{ route("staff.master-psb.student-detail.handle") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: '{{ $detail->user_id }}',
                    type: type,
                    action: action,
                    reason: reason
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        }
    </script>
@endpush