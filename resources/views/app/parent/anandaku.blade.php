@extends('_layouts.mobile-layouts.index')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="alert alert-danger text-center" role="alert">
                <h1 class="alert-heading">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                </h1>
                <h6>Akun anda belum terhubung dengan data Ananda, Hubungkan sekarang dengan memasukkan nomor NIS/NISN</h6>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" id="nis_nisn" name="nis_nisn" placeholder="Masukkan NIS/NISN" required>
            </div>
            <div class="form-group text-center">
                <button type="button" id="btnFindData" class="btn btn-primary mt-3 " id="submit">Cari Data</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-mobile')
    <script>
        $('#btnFindData').on('click', function() {
            var nis_nisn = $('#nis_nisn').val();
            if (nis_nisn) {
                $.ajax({
                    url: "{{ route('parent.anandaku.find') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        nis_nisn: nis_nisn
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            window.location.href = response.redirect_url;
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        showSwal('warning', xhr.responseJSON.message);
                    }
                });
            } else {
                showSwal('warning', 'NIS/NISN tidak boleh kosong');
            }
        });
    </script>
@endpush