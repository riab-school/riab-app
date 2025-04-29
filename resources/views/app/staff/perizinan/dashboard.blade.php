@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-blue">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="requested_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <p>
                        Permohonan izin oleh
                        <br>
                        Wali atau Staff Kesehatan
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-green">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="approved_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Di Setujui</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-red">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="rejected_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Di Tolak</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-yellow">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="cancelled_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Di Batalkan</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Sudah Check Out</h5>
                <div id="checkout_count"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-borderless" id="dataTable" width="100%">
                        <tbody id="checkout_data">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Sudah Check In</h5>
                <div id="checkin_count"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-borderless" id="dataTable" width="100%">
                        <tbody id="checkin_data">
                            
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
        $(document).ready(function() {
            $.ajax({
                url: "{{ url()->current() }}",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    $('#requested_count').html(res.data.requested_count);
                    $('#approved_count').html(res.data.approved_count);
                    $('#rejected_count').html(res.data.rejected_count);
                    $('#cancelled_count').html(res.data.cancelled_count);
                    renderTableOut(res.data.checkout_data, '#checkout_data', res.data.checkout_count);
                    renderTableIn(res.data.checkin_data, '#checkin_data', res.data.checkin_count);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        });

        function renderTableOut(data, id, count) {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>`;
            }
            data.forEach(function(item) {
                const student = item.detail.student_detail;
                const photoUrl = student.photo_url 
                    ? student.photo_url 
                    : `https://ui-avatars.com/api/?background=19BCBF&color=fff&name=${encodeURIComponent(student.name)}`;
                
                html += `
                    <tr>
                        <td>
                            <img class="rounded-circle" style="width:40px;" src="${photoUrl}" alt="activity-user">
                        </td>
                        <td>
                            <h6 class="mb-1">${student.name}</h6>
                            <p class="m-0">Alasan : ${item.reason}</p>
                            <span class="text-c-green">${item.from_date}</span> s/d <span class="text-c-green">${item.to_date}</span>
                        </td>
                        <td>
                            <p class="m-0">Izin Ke : ${item.approved_by.staff_detail.name}</p>
                            <p class="m-0">Check Out Oleh : ${item.checked_out_by.staff_detail.name}</p>
                            <p>Status : <span class="text-c-red">${item.status}</span></p>
                        </td>
                    </tr>
                `;
            });

            $(id).html(html);

            if (count > 5) {
                $('#checkout_count').html(`<tr><td colspan="3">5 dari ${count - 5} orang lainnya | Total ${count} orang</td></tr>`);
            }
        }

        function renderTableIn(data, id, count) {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>`;
            }
            data.forEach(function(item) {
                const student = item.detail.student_detail;
                const photoUrl = student.photo_url 
                    ? student.photo_url 
                    : `https://ui-avatars.com/api/?background=19BCBF&color=fff&name=${encodeURIComponent(student.name)}`;
                
                html += `
                    <tr>
                        <td>
                            <img class="rounded-circle" style="width:40px;" src="${photoUrl}" alt="activity-user">
                        </td>
                        <td>
                            <h6 class="mb-1">${student.name}</h6>
                            <p class="m-0">Alasan : ${item.reason}</p>
                            <span class="text-c-green">${item.from_date}</span> s/d <span class="text-c-green">${item.to_date}</span>
                        </td>
                        <td>
                            <p class="m-0">Izin Ke : ${item.approved_by.staff_detail.name}</p>
                            <p class="m-0">Check In Oleh : ${item.checked_in_by.staff_detail.name}</p>
                            <p>Status : <span class="text-c-green">${item.status}</span></p>
                        </td>
                    </tr>
                `;
            });

            $(id).html(html);

            if (count > 5) {
                $('#checkin_count').html(`<tr><td colspan="3">5 dari ${count - 5} orang lainnya | Total ${count} orang</td></tr>`);
            }
        }



    </script>
@endpush