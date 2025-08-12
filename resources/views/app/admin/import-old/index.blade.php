@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Import Teacher / Staff Account</h5>
                <a href="{{ asset('sample/sample-staff.xlsx') }}" class="btn btn-outline-primary btn-sm m-0">
                    <i class="fas fa-download"></i>
                    Sample File
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.import.staff') }}" method="POST" enctype="multipart/form-data" onsubmit="return processData(this)">
                    @csrf
                    <div class="form-group">
                        <label for="file_staff">Upload File</label>
                        <input type="file" name="file_staff" id="file_staff" class="form-control  @error('file_staff') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
                        @error('file_staff')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Import</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Import Classroom List</h5>
                <a href="{{ asset('sample/sample-classroom.xlsx') }}" class="btn btn-outline-primary btn-sm m-0">
                    <i class="fas fa-download"></i>
                    Sample File
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.import.classroom') }}" method="POST" enctype="multipart/form-data" onsubmit="return processData(this)">
                    @csrf
                    <div class="form-group">
                        <label for="tahun_ajaran_id">Tahun Ajaran</label>
                        <select class="form-control" name="tahun_ajaran_id" id="tahun_ajaran_id" required>
                            <option></option>
                            @foreach (App\Models\MasterTahunAjaran::all() as $item)
                            <option value="{{ $item->id }}">{{ $item->tahun_ajaran }}/{{ $item->tahun_ajaran+1 }}</option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file_classroom">Upload File</label>
                        <input type="file" name="file_classroom" id="file_classroom" class="form-control  @error('file_classroom') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
                        @error('file_classroom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Import</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Import Old Student Account</h5>
                <a href="{{ asset('sample/sample-student.xlsx') }}" class="btn btn-outline-primary btn-sm m-0">
                    <i class="fas fa-download"></i>
                    Sample File
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.import.student') }}" method="POST" enctype="multipart/form-data" onsubmit="return processData(this)">
                    @csrf
                    <div class="form-group">
                        <label for="tahun_ajaran_id">Tahun Ajaran</label>
                        <select class="form-control" name="tahun_ajaran_id" id="tahun_ajaran_id_1" required>
                            <option></option>
                            @foreach (App\Models\MasterTahunAjaran::all() as $item)
                            <option value="{{ $item->id }}">{{ $item->tahun_ajaran }}/{{ $item->tahun_ajaran+1 }}</option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="classroom_id">Kelas</label>
                        <select class="form-control" name="classroom_id" id="classroom_id" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file_old_student">Upload File</label>
                        <input type="file" name="file_old_student" id="file_old_student" class="form-control  @error('file_old_student') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
                        @error('file_old_student')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select class="form-control" name="is_active" id="is_active" required>
                            <option></option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Import</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Import Dormitory List</h5>
                <a href="{{ asset('sample/sample-dormitory.xlsx') }}" class="btn btn-outline-primary btn-sm m-0">
                    <i class="fas fa-download"></i>
                    Sample File
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.import.dormitory') }}" method="POST" enctype="multipart/form-data" onsubmit="return processData(this)">
                    @csrf
                    <div class="form-group">
                        <label for="tahun_ajaran_id">Tahun Ajaran</label>
                        <select class="form-control" name="tahun_ajaran_id" id="tahun_ajaran_id" required>
                            <option></option>
                            @foreach (App\Models\MasterTahunAjaran::all() as $item)
                            <option value="{{ $item->id }}">{{ $item->tahun_ajaran }}/{{ $item->tahun_ajaran+1 }}</option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file_dormitory">Upload File</label>
                        <input type="file" name="file_dormitory" id="file_dormitory" class="form-control  @error('file_dormitory') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
                        @error('file_dormitory')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Import</button>
                </form>
            </div>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
    <script>
        // on tahun_ajaran_id change, get classroom list
        $('#tahun_ajaran_id_1').on('change', function() {
            var tahun_ajaran_id = $(this).val();
            $.ajax({
                url: "{{ route('admin.import.classroom.get') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    tahun_ajaran_id: tahun_ajaran_id
                },
                success: function(response) {
                    $('#classroom_id').empty();
                    $('#classroom_id').append('<option></option>');
                    $.each(response.data, function(index, item) {
                        $('#classroom_id').append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            });
        });
    </script>
@endpush