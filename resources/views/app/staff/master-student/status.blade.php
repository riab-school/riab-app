@extends('_layouts.app-layouts.index')  
@section('content') 
<div class="col-sm-12">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-naik-kelas-tab" data-bs-toggle="pill"
                href="#pills-naik-kelas" role="tab" aria-controls="pills-naik-kelas"
                aria-selected="false">Naik Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-pindah-kelas-tab" data-bs-toggle="pill"
                href="#pills-pindah-kelas" role="tab" aria-controls="pills-pindah-kelas"
                aria-selected="false">Pindah Kelas</a>
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
        {{-- Naik Kelas --}}
        <div class="tab-pane fade show active" id="pills-naik-kelas" role="tabpanel" aria-labelledby="pills-naik-kelas-tab">
            <h5>Naik Kelas</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h5>Tahun Ajaran Asal | <span class="text-danger">{{ session()->get('tahun_ajaran_aktif') }}/{{ session()->get('tahun_ajaran_aktif') + 1 }}</span> </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6 mb-3 mb-lg-0">
                                    <label for="filter_grade_from_1">Tingkat / Grade</label>
                                    <select name="filter_grade_from_1" id="filter_grade_from_1" class="form-control">
                                        <option value="">Pilih Tingkat</option>
                                        <option value="X">X</option>
                                        <option value="XI">XI</option>
                                        <option value="XII">XII</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 mb-lg-0">
                                    <label for="filter_classroom_from_1">Kelas</label>
                                    <select name="filter_classroom_from_1" id="filter_classroom_from_1" class="form-control">
                                        <option value="" disabled>Silahkan Pilih Tingkat Dulu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="dataTableFrom1" class="table table-sm table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h5>Tahun Ajaran Tujuan | <span class="text-danger">{{ session()->get('tahun_ajaran_aktif') + 1 }}/{{ session()->get('tahun_ajaran_aktif') + 2 }}</span> </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6 mb-3 mb-lg-0">
                                    <label for="filter_grade_to_1">Tingkat / Grade</label>
                                    <select name="filter_grade_to_1" id="filter_grade_to_1" class="form-control">
                                        <option value="">Pilih Tingkat</option>
                                        <option value="X">X</option>
                                        <option value="XI">XI</option>
                                        <option value="XII">XII</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 mb-lg-0">
                                    <label for="filter_classroom_to_1">Kelas</label>
                                    <select name="filter_classroom_to_1" id="filter_classroom_to_1" class="form-control">
                                        <option value="" disabled>Silahkan Pilih Tingkat Dulu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="dataTableTo1" class="table table-sm table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pindah Kelas --}}
        <div class="tab-pane fade" id="pills-pindah-kelas" role="tabpanel" aria-labelledby="pills-pindah-kelas-tab">
            <h5>Pindah Kelas</h5>
            <hr>
        </div>

        {{-- Pindah Asrama --}}
        <div class="tab-pane fade" id="pills-pindah-asrama" role="tabpanel" aria-labelledby="pills-pindah-asrama-tab">
            <h5>Pindah Asrama</h5>
            <hr>
        </div>

        {{-- Tamat --}}
        <div class="tab-pane fade" id="pills-tamat" role="tabpanel" aria-labelledby="pills-tamat-tab">
            <h5>Tamat / Wisuda</h5>
            <hr>
        </div>

        {{-- Pindah Sekolah --}}
        <div class="tab-pane fade" id="pills-pindah-sekolah" role="tabpanel" aria-labelledby="pills-pindah-sekolah-tab">
            <h5>Pindah Sekolah</h5>
            <hr>
        </div>

        {{-- Drop Out --}}
        <div class="tab-pane fade" id="pills-drop-out" role="tabpanel" aria-labelledby="pills-drop-out-tab">
            <h5>Drop Out</h5>
            <hr>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    $(document).ready(function(){
        var table = null;

        $('#filter_classroom_from_1').on('change', function(){
            $('#dataTableFrom1').DataTable().destroy();
            var selectedClassroom = $(this).val();

            if(selectedClassroom){
                initializeDataTable(selectedClassroom);
            } else {
                table.destroy();
                table = null;
            }
        });

        function initializeDataTable(selectedClassroom){
            table = $('#dataTableFrom1').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('staff.master-student.status.naik-kelas-from') }}",
                    data: function(d){
                        d.classroom = selectedClassroom;
                    }
                },
                drawCallback: function() {
                    $('.pagination').addClass('pagination-sm');
                },
                columns: [
                    {
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `<div class="btn-group">
                                        <a href="{{ route('staff.master-student.detail') }}?id=${row.id}" class="btn btn-icon btn-outline-info"><i class="fas fa-edit"></i></a>
                                    </div>`;
                        }
                    },
                    { data: 'student_detail.nis', name: 'nis' },
                    { data: 'student_detail.nisn', name: 'nisn' },
                    { data: 'student_detail.name', name: 'name' },
                    { data: 'gender', name: 'gender' },
                    { data: 'ttl', name: 'ttl' },
                    { data: 'address', name: 'address' },
                ]
            });
        }

        $('#resetForm_1').on('click', function(){
            $('#filter_classroom_from_1').val('');
            $('#filter_grade_from_1').val('');
            if(table !== null){
                table.destroy();
                table = null;
            }
        });
    });

    $('#filter_grade_from_1').on('change', function(){
        $.ajax({
            url: "{{ route('staff.master-student.classrooms') }}",
            type: 'GET',
            data: {
                grade: $(this).val()
            },
            beforeSend: function(){
                $('#filter_classroom_from_1').empty();
            },
            success: function(response){
                $('#filter_classroom_from_1').html('<option>Pilih Kelas</option>');
                $.each(response, function(index, item){
                    $('#filter_classroom_from_1').append(`<option value="${item.id}">${item.name}</option>`);
                });
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const hash = window.location.hash;
        if (hash) {
            const activeTab = document.querySelector(`a[href="${hash}"]`);
            if (activeTab) {
                const tab = new bootstrap.Tab(activeTab);
                tab.show();
            }
        }
    });
</script>
@endpush