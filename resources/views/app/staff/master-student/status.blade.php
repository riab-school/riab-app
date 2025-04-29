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