@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Create Classroom For <span class="text-danger">{{ Session::get('tahun_ajaran_aktif') }}/{{ Session::get('tahun_ajaran_aktif')+1 }}</span></h5>
            </div>
            <form action="{{ route('staff.kelas.create.handle') }}" method="POST" onsubmit="return processData(this)">
                @csrf
                <input type="hidden" name="tahun_ajaran_id" id="tahun_ajaran_id" value="{{ Session::get('tahun_ajaran_aktif_id') }}" required>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="grade">Grade Kelas</label>
                                <select name="grade" id="grade" class="form-control" required>
                                    <option value=""></option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="focus">Fokus Kelas</label>
                                <select name="focus" id="focus" class="form-control" required>
                                    <option value=""></option>
                                    <option value="mipa">MIPA</option>
                                    <option value="agama">AGAMA</option>
                                    <option value="others">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="number">Number</label>
                                <input type="number" name="number" id="number" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Kelas</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="limitation">Batas Siswa</label>
                                <input type="text" name="limitation" id="limitation" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="location">Lokasi Kelas (Opsional)</label>
                                <input type="text" name="location" id="location" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="head_id">Wali Kelas (Umum)</label>
                                <select name="head_id" id="head_id" class="form-control" required>
                                    <option value=""></option>
                                    @foreach (\App\Models\User::where('user_level', 'staff')->with('staffDetail')->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->staffDetail->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="head_tahfidz_id">Wali Kelas (Tahfidz)</label>
                                <select name="head_tahfidz_id" id="head_tahfidz_id" class="form-control" required>
                                    <option value=""></option>
                                    @foreach (\App\Models\User::where('user_level', 'staff')->with('staffDetail')->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->staffDetail->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="feather icon-save"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="feather icon-refresh-ccw"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        // Gabung Grade Focus Number jadi name
        $('#grade, #focus, #number').on('change', function() {
            let grade = $('#grade').val();
            let focus = $('#focus').val().toUpperCase();
            let number = $('#number').val();
            $('#name').val(`${grade}-${focus}-${number}`);
        });
    </script>
@endpush