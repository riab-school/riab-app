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
                    <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->photo !== NULL ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->photo) : asset('assets/images/blank_person.jpg') }}" class="img-radius wid-100 m-auto" alt="User-Profile-Image">
                </div>
                <h6 class="f-w-600 m-t-25 m-b-10">{{ auth()->user()->myDetail->name }}</h6>
                <p>{{ ucfirst(auth()->user()->myDetail->status) }} | {{ ucfirst(auth()->user()->myDetail->gender) }} | {{ ucfirst(strtolower(auth()->user()->myDetail->place_of_birth)).", ". \Carbon\Carbon::parse(auth()->user()->myDetail->date_of_birth)->format('d F Y') }}</p>
                <hr>
                <div class="bg-c-blue counter-block m-t-10 p-20 rounded">
                    <div class="row">
                        <div class="col-6">
                            <i class="fas fa-building text-white f-20"></i>
                            <h6 class="text-white mt-2 mb-0">{{ auth()->user()->myDetail->studentClassroom ? auth()->user()->myDetail->studentClassroom->classroomDetail->name : 'N/A' }}</h6>
                        </div>
                        <div class="col-6">
                            <i class="fas fa-home text-white f-20"></i>
                            <h6 class="text-white mt-2 mb-0">{{ auth()->user()->myDetail->studentDormitory ? auth()->user()->myDetail->studentDormitory->dormitoryDetail->name . " - Lantai " . auth()->user()->myDetail->studentDormitory->dormitoryDetail->level : 'N/A' }}</h6>
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
            <div class="card-body">
                <center>
                    <h5>Coming Soon</h5>
                </center>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card user-card h-100">
            <div class="card-header">
                <h5>Log Aktivitas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-sm table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Timestamp</th>
                                <th>User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ url()->current() }}",
                drawCallback: function() {
                    $('.pagination').addClass('pagination-sm');
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'user_agent',
                        name: 'user_agent',
                    }
                ]
            });
        });
    </script>
@endpush