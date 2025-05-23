@extends('_layouts.mobile-layouts.index')
@section('title', 'Update Password')
@section('content')
    <div class="container">
        <div class="profile-wrapper-area py-3">
            <div class="card user-info-card">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="user-profile me-3">
                        <img src="{{ auth()->user()->myDetail->photo == 'default.png' ? asset('assets/images/blank_person.jpg') : Storage::disk('s3')->url(auth()->user()->myDetail->photo)  }}" alt="profile_image">
                    </div>
                    <div class="user-info">
                        <p class="mb-0 text-dark">Update Password</p>
                        <h5 class="mb-0">{{ auth()->user()->myDetail->name }}</h5>
                    </div>
                </div>
            </div>
            <div class="card user-data-card">
                <div class="card-body">
                    <form action="{{ route('parent.password.update') }}" method="POST" onsubmit="processData(this);">
                        @csrf
                        <div class="mb-3">
                            <div class="title mb-2">
                                <i class="fa-solid fa-key"></i><span>Old Password</span>
                            </div>
                            <input class="form-control" type="password" name="old_password" placeholder="Old Password" required>
                        </div>
                        <div class="mb-3">
                            <div class="title mb-2">
                                <i class="fa-solid fa-key"></i><span>New Password</span>
                            </div>
                            <input class="input-psswd form-control" id="registerPassword" name="new_password" type="password" placeholder="Password">
                        </div>
                        <div class="mb-3">
                            <div class="title mb-2"><i class="fa-solid fa-key"></i><span>Repeat New Password</span></div>
                                <input class="form-control" type="password" name="new_password_confirmation" placeholder="Repeat Password" required>
                                <div class="password-meter-wrapper progress" style="display: none;">
                                <div id="password-progress" class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:1%;"></div>
                            </div>
                            <div id="password-score" class="password-score" style="display: none;"></div>
                            <div id="password-recommendation" class="password-recommendation"></div>
                            <input type="hidden" id="password-strength-score" value="0">
                        </div>
                        <button class="btn btn-success w-100" type="submit">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>   
@endsection