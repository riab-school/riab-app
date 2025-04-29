@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Filter Laporan</h5>
            </div>
            <form action="{{ route('staff.perizinan.laporan.handle') }}" method="POST" onsubmit="processData(this);">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="from_date">Tanggal Awal</label>
                        <input type="date" class="form-control @error('from_date') is-invalid @enderror" id="from_date" name="from_date" required>
                        @error('from_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="to_date">Tanggal Akhir</label>
                        <input type="date" class="form-control @error('to_date') is-invalid @enderror" id="to_date" name="to_date" required>
                        @error('to_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Tampilkan</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection