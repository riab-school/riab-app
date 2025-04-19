@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Student List</h5>
        <button class="btn btn-outline-primary btn-sm" id="resetForm">Reset Filter</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3 mb-lg-0">
                <label for="filter_grade">Tingkat / Grade</label>
                <select name="filter_grade" id="filter_grade" class="form-control">
                    <option value="">Pilih Tingkat</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>
            </div>
            <div class="col-md-3 mb-3 mb-lg-0">
                <label for="filter_classroom">Kelas</label>
                <select name="filter_classroom" id="filter_classroom" class="form-control">
                    <option value="" disabled>Silahkan Pilih Tingkat Dulu</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-hover" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>TTL</th>
                        <th>Provinsi / Kabupaten</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            var table = null;

            $('#filter_classroom').on('change', function(){
                $('#dataTable').DataTable().destroy();
                var selectedClassroom = $(this).val();

                if(selectedClassroom){
                    initializeDataTable(selectedClassroom);
                } else {
                    table.destroy();
                    table = null;
                }
            });

            function initializeDataTable(selectedClassroom){
                table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ url()->current() }}",
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
                                            <a href="{{ route('staff.master-student.detail') }}?id=${row.id}" class="btn btn-icon btn-outline-info"><i class="fas fa-eye"></i></a>
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

            $('#resetForm').on('click', function(){
                $('#filter_classroom').val('');
                $('#filter_grade').val('');
                if(table !== null){
                    table.destroy();
                    table = null;
                }
            });
        });

        $('#filter_grade').on('change', function(){
            $.ajax({
                url: "{{ route('staff.master-student.classrooms') }}",
                type: 'GET',
                data: {
                    grade: $(this).val()
                },
                beforeSend: function(){
                    $('#filter_classroom').empty();
                },
                success: function(response){
                    $('#filter_classroom').html('<option>Pilih Kelas</option>');
                    $.each(response, function(index, item){
                        $('#filter_classroom').append(`<option value="${item.id}">${item.name}</option>`);
                    });
                }
            });
        });
    </script>
@endpush