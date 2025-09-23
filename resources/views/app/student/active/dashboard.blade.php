@extends('_layouts.app-layouts.index')

@section('content')
<div class="row mb-2">
    <div class="col-md-12">
        <div class="page-header-title">
            <h5>Assalamualaikum, {{ auth()->user()->myDetail->name }}</h5>
            <h6>{{ \Carbon\Carbon::now()->format('l, d F Y') }}</h6>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card user-card h-100">
            <div class="card-header">
                <h5>Data Siswa</h5>
            </div>
            <div class="card-body  text-center">
                <div class="usre-image">
                    <img src="#" class="img-radius wid-100 m-auto" alt="User-Profile-Image">
                </div>
                <h6 class="f-w-600 m-t-25 m-b-10">{{ auth()->user()->myDetail->name }}</h6>
                <p>{{ ucfirst(auth()->user()->myDetail->status) }} | {{ ucfirst(auth()->user()->myDetail->gender) }} | {{ ucfirst(strtolower(auth()->user()->myDetail->place_of_birth)).", ". \Carbon\Carbon::parse(auth()->user()->myDetail->date_of_birth)->format('d F Y') }}</p>
                <hr>
                <div class="bg-c-blue counter-block m-t-10 p-20 rounded">
                    <div class="row">
                        <div class="col-4">
                            <i class="fas fa-building text-white f-20"></i>
                            <h6 class="text-white mt-2 mb-0"></h6>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-user text-white f-20"></i>
                            <h6 class="text-white mt-2 mb-0"></h6>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-folder-open text-white f-20"></i>
                            <h6 class="text-white mt-2 mb-0"></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card user-card h-100">
            <div class="card-header">
                <h5>Perkembangan Akademik</h5>
            </div>
            <div class="card-body  text-center">
                
            </div>
        </div>
    </div>
</div>

@endsection