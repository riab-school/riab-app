@extends('_layouts.mobile-layouts.index')
@section('title', 'My Profile')
@section('content')
    <div class="container">
        <div class="profile-wrapper-area py-3">
            <div class="card user-info-card">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="user-profile me-3">
                        <img src="{{ auth()->user()->myDetail->photo == 'default.png' ? asset('assets/images/blank_person.jpg') : Storage::disk('s3')->url(auth()->user()->myDetail->photo)  }}" alt="profile_image">
                        <div class="change-user-thumb">
                            <input class="form-control-file" type="file" id="user-thumb" name="photo" accept="image/*" required>
                            <button><i class="fa-solid fa-pen"></i></button>
                        </div>
                    </div>
                    <div class="user-info">
                        <p class="mb-0 text-dark">My Profile</p>
                        <h5 class="mb-0">{{ auth()->user()->myDetail->name }}</h5>
                    </div>
                </div>
            </div>
            <div class="card user-data-card">
                <div class="card-body">
                    <form action="{{ route('parent.profile.update') }}" method="POST" onsubmit="processData(this);">
                        @csrf
                        <div class="mb-3">
                            <div class="title mb-2"><i class="fa-solid fa-at"></i><span>Username</span></div>
                            <input class="form-control" type="text" value="{{ auth()->user()->username }}" disabled>
                        </div>
                        <div class="mb-3">
                            <div class="title mb-2"><i class="fa-solid fa-user"></i><span>Full Name</span></div>
                            <input class="form-control" type="text" value="{{ auth()->user()->myDetail->name }}" name="name" id="name"  required>
                        </div>
                        <div class="mb-3">
                            <div class="title mb-2"><i class="fa-solid fa-phone"></i><span>Whatsapp Number</span></div>
                            <input class="form-control" type="text" value="{{ auth()->user()->myDetail->phone }}" name="phone" id="phone"  required>
                        </div>
                        <button class="btn btn-success w-100" type="submit">Save All Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>   
@endsection

@push('scripts-mobile')
    <script>
        // on upload image do ajax to upload image
        $('#user-thumb').change(function() {
            var formData = new FormData();
            formData.append('photo', $(this)[0].files[0]);
            formData.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('parent.profile.update') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    Swal.showLoading();
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.close();
                        showSwal('success', 'Image updated successfully', true);
                    }
                }
            });
        });
    </script>
    
@endpush