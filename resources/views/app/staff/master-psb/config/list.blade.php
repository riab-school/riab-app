@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Psb Config</h5>
        <a href="{{ route('staff.master-psb.add-config') }}" class="btn btn-outline-primary btn-sm" id="resetForm">Add Config</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-hover" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2">Action</th>
                        <th rowspan="2">Tahun Ajaran</th>
                        <th rowspan="2">Ketua Panitia</th>
                        <th rowspan="2">Kode Undangan</th>
                        <th rowspan="2">Biaya Psb Reguler</th>
                        <th colspan="4" class="text-center">Jalur Undangan</th>
                        <th colspan="3" class="text-center">Jalur Reguler</th>
                        <th rowspan="2">Status</th>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>Lulus</th>
                        <th>Tidak Lulus</th>
                        <th>Pindah Reguler</th>
                        <th>Total</th>
                        <th>Lulus</th>
                        <th>Tidak Lulus</th>
                    </tr>
                </thead>                
                <tbody>
                    @foreach ($dataConfig as $item)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('staff.master-psb.edit-config') }}?id={{ $item->id }}" class="btn btn-icon btn-outline-info"><i class="fas fa-edit"></i></a>
                                <a href="" class="btn btn-icon btn-outline-info"><i class="feather icon-power"></i></a>
                            </div>
                        </td>
                        <td>{{ $item->tahun_ajaran }}</td>
                        <td>{{ $item->ketua_panitia }}</td>
                        <td>{{ $item->kode_undangan }}</td>
                        <td>{{ rupiah($item->biaya_psb) }}</td>
                        <td>{{ $item->jumlah_pendaftar_undangan }}</td>
                        <td>{{ $item->jumlah_pendaftar_undangan_lulus }}</td>
                        <td>{{ $item->jumlah_pendaftar_undangan_tidak_lulus }}</td>
                        <td>{{ $item->jumlah_pendaftar_undangan_pindah }}</td>
                        <td>{{ $item->jumlah_pendaftar_reguler }}</td>
                        <td>{{ $item->jumlah_pendaftar_reguler_lulus }}</td>
                        <td>{{ $item->jumlah_pendaftar_reguler_tidak_lulus }}</td>
                        <td>{!! $item->is_active ? '<span class="badge badge-light-primary">Aktif</span>' : '<span class="badge badge-light-danger">Tidak Aktif</span>' !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush