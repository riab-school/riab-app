@extends('_layouts.app-layouts.index')  
@section('content') 
<div class="col-sm-12">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-assign-kelas-tab" data-bs-toggle="pill"
                href="#pills-assign-kelas" role="tab" aria-controls="pills-assign-kelas"
                aria-selected="false">Assign Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-naik-kelas-tab" data-bs-toggle="pill"
                href="#pills-naik-kelas" role="tab" aria-controls="pills-naik-kelas"
                aria-selected="false">Naik Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-pindah-kelas-tab" data-bs-toggle="pill"
                href="#pills-pindah-kelas" role="tab" aria-controls="pills-pindah-kelas"
                aria-selected="false">Pindah Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-assign-asrama-tab" data-bs-toggle="pill"
                href="#pills-assign-asrama" role="tab" aria-controls="pills-assign-asrama"
                aria-selected="false">Assign Asrama</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-pindah-asrama-tab" data-bs-toggle="pill"
                href="#pills-pindah-asrama" role="tab" aria-controls="pills-pindah-asrama"
                aria-selected="false">Pindah Asrama</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-tamat-tab" data-bs-toggle="pill"
                href="#pills-tamat" role="tab" aria-controls="pills-tamat"
                aria-selected="false">Tamat & Wisuda</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-pindah-sekolah-tab" data-bs-toggle="pill"
                href="#pills-pindah-sekolah" role="tab" aria-controls="pills-pindah-sekolah"
                aria-selected="false">Pindah Sekolah</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-drop-out-tab" data-bs-toggle="pill"
                href="#pills-drop-out" role="tab" aria-controls="pills-drop-out"
                aria-selected="false">Drop Out</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        
        @include('app.staff.master-student.status-tab.assign-kelas')

        @include('app.staff.master-student.status-tab.naik-kelas')

        @include('app.staff.master-student.status-tab.pindah-kelas')

        @include('app.staff.master-student.status-tab.assign-asrama')

        @include('app.staff.master-student.status-tab.pindah-asrama')

        @include('app.staff.master-student.status-tab.tamat-wisuda')

        @include('app.staff.master-student.status-tab.pindah-sekolah')

        @include('app.staff.master-student.status-tab.drop-out')

        
    </div>
</div>

@endsection