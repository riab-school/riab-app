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