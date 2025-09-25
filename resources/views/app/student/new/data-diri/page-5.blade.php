@extends('_layouts.app-layouts.index')

@php
    $health = auth()->user()->myDetail->studentHealthDetail ?? null;
    $disabled = $health && $health->is_completed ? 'disabled' : '';
@endphp
@section('content')
@include('app.student.new.data-diri.running-text')
<div class="row">
    <div class="col-md-2">
        @include('app.student.new.data-diri.switcher')
    </div>
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5>Informasi Data Kesehatan</h5>
            </div>
            <div class="card-body">
                @if($health && $health->is_completed)
                    <div class="alert alert-danger" role="alert">
                        Data kesehatan Anda sudah diverifikasi, anda dapat melakukan perubahan data dengan menghubungi admin atau panitia.
                    </div>
                @endif
                <form action="{{ route('student.new.data-diri.store-page-5') }}" method="POST" onsubmit="return processData(this)">
                    @if(!$health || !$health->is_completed)
                    @csrf
                    @endif
                    <div class="row">
                        <div class="col-md-4 text-center mx-auto mb-3">
                            <label for="blood" class="form-label">Golongan Darah</label>
                            <select name="blood" id="blood" class="form-control @error('blood') is-invalid @enderror" required {{ $disabled }}>
                                @php
                                    $bloodGroups = ['A+', 'B+', 'AB+', 'O+', 'A-', 'B-', 'AB-', 'O-'];
                                @endphp
                                <option value="">Pilih Golongan Darah</option>
                                @foreach($bloodGroups as $group)
                                    <option value="{{ $group }}" {{ old('blood', $health->blood ?? '') == $group ? 'selected' : '' }}>
                                        {{ $group }}
                                    </option>
                                @endforeach
                            </select>
                            @error('blood')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <div class="row">
    
                        <div class="col-md-6 mb-3">
                            <label for="food_alergic" class="form-label">Alergi Makanan</label>
                            <input type="text" name="food_alergic" id="food_alergic" placeholder="Pisahkan dengan koma" class="form-control @error('food_alergic') is-invalid @enderror" value="{{ old('food_alergic', $health->food_alergic ?? '') }}" {{ $disabled }}>
                            @error('food_alergic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="drug_alergic" class="form-label">Alergi Obat</label>
                            <input type="text" name="drug_alergic" id="drug_alergic" placeholder="Pisahkan dengan koma" class="form-control @error('drug_alergic') is-invalid @enderror" value="{{ old('drug_alergic', $health->drug_alergic ?? '') }}" {{ $disabled }}>
                            @error('drug_alergic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="other_alergic" class="form-label">Alergi Lainnya</label>
                        <input type="text" name="other_alergic" id="other_alergic" placeholder="Pisahkan dengan koma" class="form-control @error('other_alergic') is-invalid @enderror" value="{{ old('other_alergic', $health->other_alergic ?? '') }}" {{ $disabled }}>
                        @error('other_alergic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="disease_history" class="form-label">Riwayat Penyakit</label>
                        <textarea name="disease_history" id="disease_history" placeholder="Pisahkan dengan koma" class="form-control @error('disease_history') is-invalid @enderror" {{ $disabled }}>{{ old('disease_history', $health->disease_history ?? '') }}</textarea>
                        @error('disease_history')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="disease_ongoing" class="form-label">Penyakit yang Sedang Dialami</label>
                        <textarea name="disease_ongoing" id="disease_ongoing" placeholder="Pisahkan dengan koma" class="form-control @error('disease_ongoing') is-invalid @enderror" {{ $disabled }}>{{ old('disease_ongoing', $health->disease_ongoing ?? '') }}</textarea>
                        @error('disease_ongoing')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="drug_consumption" class="form-label">Obat yang Dikonsumsi</label>
                        <textarea name="drug_consumption" id="drug_consumption" placeholder="Pisahkan dengan koma" class="form-control @error('drug_consumption') is-invalid @enderror" {{ $disabled }}>{{ old('drug_consumption', $health->drug_consumption ?? '') }}</textarea>
                        @error('drug_consumption')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="weight" class="form-label">Berat Badan (kg)</label>
                            <div class="input-group">
                                <input type="number" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight', $health->weight ?? '') }}" {{ $disabled }}>
                                <span class="input-group-text">kg</span>
                            </div>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <div class="col-6 mb-3">
                            <label for="height" class="form-label">Tinggi Badan (cm)</label>
                            <div class="input-group">
                                <input type="number" name="height" id="height" class="form-control @error('height') is-invalid @enderror" value="{{ old('height', $health->height ?? '') }}" {{ $disabled }}>
                                <span class="input-group-text">cm</span>
                            </div>
                            @error('height')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" {{ $disabled }}>Simpan dan Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
