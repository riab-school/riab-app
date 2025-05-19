@extends('_layouts.mobile-layouts.index')

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
                    <input class="checkbox" type="checkbox" checked>
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
                    <a href="#">Get Help<i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="card settings-card">
        <div class="card-body">
            <div class="single-settings d-flex align-items-center justify-content-between">
                <div class="title">
                    <i class="fa-solid fa-key"></i>
                    <span>Password<span>Updated 1 month ago</span></span>
                </div>
                <div class="data-content">
                    <a href="#">Change<i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection