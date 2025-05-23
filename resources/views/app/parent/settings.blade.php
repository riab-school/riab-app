@extends('_layouts.mobile-layouts.index')
@section('title', 'Pengaturan Akun')
@section('content')
<div class="container">
    <div class="settings-wrapper py-3">
        <div class="card settings-card">
            <div class="card-body">
                <div class="single-settings d-flex align-items-center justify-content-between">
                    <div class="title">
                        <i class="fa-solid fa-moon"></i>
                        <span>Mode Malam</span>
                    </div>
                    <div class="data-content">
                        <div class="toggle-button-cover">
                            <div class="button r">
                            <input class="checkbox" id="darkSwitch" type="checkbox">
                            <div class="knobs"></div>
                            <div class="layer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card settings-card">
            <div class="card-body">
                <div class="single-settings d-flex align-items-center justify-content-between">
                    <div class="title">
                        <i class="fa-solid fa-bell"></i>
                        <span>Terima Notifikasi Whatsapp</span>
                    </div>
                    <div class="data-content">
                        <div class="toggle-button-cover">
                            <div class="button r">
                            <input class="checkbox" type="checkbox" id="is_allow_send_wa" {{ auth()->user()->myDetail->is_allow_send_wa ? 'checked' : '' }}>
                            <div class="knobs"></div>
                            <div class="layer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card settings-card">
            <div class="card-body">
                <div class="single-settings d-flex align-items-center justify-content-between">
                    <div class="title">
                        <i class="fa-solid fa-circle-question"></i>
                        <span>Bantuan</span>
                    </div>
                    <div class="data-content">
                        <a href="https://wa.me/6281263280610" target="_blank">Dapatkan Bantuan<i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card settings-card">
            <div class="card-body">
                <div class="single-settings d-flex align-items-center justify-content-between">
                    <div class="title">
                        <i class="fa-solid fa-key"></i>
                        <span>Password<span>Updated {{ \Carbon\Carbon::parse(auth()->user()->password_changed_at)->diffForHumans() }}</span></span>
                    </div>
                    <div class="data-content">
                        <a href="{{ route('parent.password') }}">Change<i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-mobile')
    <script>
        $('#is_allow_send_wa').change(function() {
            var is_allow_send_wa = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: "{{ route('parent.settings.update-notification') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    is_allow_send_wa: is_allow_send_wa
                },
                success: function(response) {
                    if (response.status == 'success') {
                        showSwal('success', 'Pengaturan berhasil diperbarui', true);
                    } else {
                        showSwal('error', 'Pengaturan gagal diperbarui', false);
                    }
                },
                error: function(xhr) {
                    showSwal('error', 'Terjadi kesalahan, silahkan coba lagi', false);
                }
            });
        });
    </script>
@endpush