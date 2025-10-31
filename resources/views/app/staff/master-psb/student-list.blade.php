@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Student List</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-hover" style="width: 100%">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Asal Sekolah</th>
                        <th>Asal Daerah</th>
                        <th>Status Berkas</th>
                        <th>Status Kelulusan SMBP</th>
                        <th>NIK KTP</th>
                        <th>NIK KK</th>
                        <th>No. Akte</th>
                        <th>NISN</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>No. Telepon</th>
                        <th>Negara</th>
                        <th>Alamat</th>
                        <th>Provinsi</th>
                        <th>Kabupaten/Kota</th>
                        <th>Kecamatan</th>
                        <th>Desa/Kelurahan</th>
                        <th>Kode Pos</th>
                        <th>Anak Ke-</th>
                        <th>Dari Anak Ke-</th>
                        <th>Hobi</th>
                        <th>Cita-cita</th>
                        <th>Anak Kandung ?</th>
                    </tr>
                </thead>                
                <tbody>
                    @forelse ($dataStudent as $item)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('staff.master-psb.student-detail', $item->id) }}" 
                                    class="btn btn-outline-info btn-verifikasi">
                                    <i class="fas fa-edit"></i> Detail
                                </a>
                            </div>
                        </td>
                        <td>{{ $item->name ?? NULL }}</td>
                        <td>{{ $item->nis ?? NULL }}</td>
                        <td>{{ $item->studentOriginDetail->origin_school ?? NULL }}</td>
                        <td>{{ $item->cityDetail->name ?? NULL }}</td>
                        <td>
                            {!! 
                                $item->studentDocument
                                ? ($item->studentDocument->is_completed
                                    ? '<span class="badge bg-success">Sudah Diverifikasi</span>'
                                    : '<span class="badge bg-warning">Menunggu Verifikasi</span>')
                                : '<span class="badge bg-danger">Belum Diupload</span>'
                            !!}
                        </td>
                        <td>
                            @if($item->psbHistory->is_administration_pass === null)
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            @elseif($item->psbHistory->is_administration_pass == NULL)
                                <span class="badge bg-success">Kelulusan belum di tetapkan</span>
                            @elseif($item->psbHistory->is_administration_pass == 1)
                                <span class="badge bg-success">Lulus</span>
                            @elseif($item->psbHistory->is_administration_pass == 0)
                                <span class="badge bg-danger">Tidak Lulus</span>
                            @endif
                        </td>
                        <td>{{ $item->nik_ktp ?? NULL }}</td>
                        <td>{{ $item->nik_kk ?? NULL }}</td>
                        <td>{{ $item->akte_number ?? NULL }}</td>
                        <td>{{ $item->nisn ?? NULL }}</td>
                        <td>{{ $item->place_of_birth ?? NULL }}</td>
                        <td>{{ $item->date_of_birth ?? NULL }}</td>
                        <td>{{ $item->gender ?? NULL }}</td>
                        <td>{{ $item->phone ?? NULL }}</td>
                        <td>{{ $item->country ?? NULL }}</td>
                        <td>{{ $item->address ?? NULL }}</td>
                        <td>{{ $item->provinceDetail->name ?? NULL }}</td>
                        <td>{{ $item->cityDetail->name ?? NULL }}</td>
                        <td>{{ $item->districtDetail->name ?? NULL }}</td>
                        <td>{{ $item->villageDetail->name ?? NULL }}</td>
                        <td>{{ $item->postal_code ?? NULL }}</td>
                        <td>{{ $item->child_order ?? NULL }}</td>
                        <td>{{ $item->from_child_order ?? NULL }}</td>
                        <td>{{ $item->hobby ?? NULL }}</td>
                        <td>{{ $item->ambition ?? NULL }}</td>
                        <td>{{ $item->is_biological ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: false
            });
        });
    </script>
@endpush