@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Rekam / Cetak KTS</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('staff.master-student.kts.detail') }}" method="POST" onsubmit="return processData(this)">
                    @csrf
                    <div class="form-group">
                        <label for="search_by">Cari Berdasarkan</label>
                        <select name="search_by" id="search_by" class="form-control" required>
                            <option value="">--Berdasarkan--</option>
                            <option value="nik_ktp">NIK (Ktp)</option>
                            <option value="nis">NIS (Lokal)</option>
                            <option value="nisn">NISN (Nasional)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="val">Value</label>
                        <input type="text" name="val" id="val" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Cari Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection