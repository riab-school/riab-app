@extends('_layouts.app-layouts.index')

@push('styles')
    <style>
        
        #webcam-container {
            position: relative;
            width: 480px; /* Sesuaikan dengan ukuran WebcamJS */
            height: 270px;
            margin: auto;
        }

        #my_camera {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; /* Kamera di bawah */
            overflow: visible !important;
        }

        .signature-container .buttons {
            text-align: center;
        }

    </style>
@endpush

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>{{ $detail->studentDetail->name }}</h5>
        <a href="{{ route('staff.master-student.kts') }}" class="btn btn-outline-danger btn-sm m-0">
            <i class="feather icon-chevron-left"></i>
            Back
        </a>
        <div class="card-header-right">
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 p-1">
                <div class="text-center">
                    <div>
                        
                        <img 
                            src="{{ $detail->studentDetail->studentDocument && $detail->studentDetail->studentDocument->photo !== NULL ? Storage::disk('s3')->url($detail->studentDetail->studentDocument->photo)."?".rand(1,32000) : asset('assets/images/blank_person.jpg') }}" 
                            data-src="{{ $detail->studentDetail->studentDocument && $detail->studentDetail->studentDocument->photo !== NULL ? Storage::disk('s3')->url($detail->studentDetail->studentDocument->photo)."?".rand(1,32000) : asset('assets/images/blank_person.jpg') }}" 
                            class="img-fluid img-thumbnail mb-1 img-preview" 
                            alt="User-Profile-Image" 
                            width="180px"
                            style="cursor: pointer;">
                    </div>
                    <div>
                        <img 
                        src="{{ $detail->studentDetail->studentDocument && $detail->studentDetail->studentDocument->signature !== NULL ? Storage::disk('s3')->url($detail->studentDetail->studentDocument->signature)."?".rand(1,32000) : asset('assets/images/blank.png') }}" 
                        class="img-fluid img-thumbnail" 
                        alt="User-Signature" 
                        width="180px">
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="d-md-flex gap-4">
                    <div class="table-responsive">
                        <table class="table table-xs" width="100%">
                            <tr>
                                <td class="fw-bold">NIK KTP</td>
                                <td class="text-end">{{ $detail->studentDetail->nik_ktp }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tempat, Tanggal Lahir</td>
                                <td class="text-end">{{ $detail->studentDetail->place_of_birth }}, {{ \Carbon\Carbon::parse($detail->studentDetail->date_of_birth)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Anak Ke</td>
                                <td class="text-end"> {{ $detail->studentDetail->child_order }} ({{ penyebut($detail->studentDetail->child_order) }} ), dari {{ $detail->studentDetail->from_child_order }} ({{ penyebut($detail->studentDetail->from_child_order) }} ) Bersaudara</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Jurusan</td>
                                <td class="text-end">{{  $detail->studentClassroom ? ($detail->studentClassroom->classroomDetail->focus == "mipa" ? "Matematika dan Ilmu Pengetahuan Alam (MIPA)" : "Ilmu Keagamaan (MAK)") : '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Jenis Kelamin</td>
                                <td class="text-end">{{ $detail->studentDetail->gender == "male" ? "Laki-Laki" : "Perempuan" }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Phone</td>
                                <td class="text-end">{{ $detail->studentDetail->phone }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-xs" width="100%">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">NIS</td>
                                    <td class="text-end">{{ $detail->studentDetail->nis }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">NISN</td>
                                    <td class="text-end">{{ $detail->studentDetail->nisn }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Hobi</td>
                                    <td class="text-end">{{ $detail->studentDetail->hobby }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Cita Cita</td>
                                    <td class="text-end">{{ $detail->studentDetail->ambition }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Kelas</td>
                                    <td class="text-end">{{ $detail->studentClassroom ? $detail->studentClassroom->classroomDetail->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Asrama</td>
                                    <td class="text-end">{{ $detail->studentDormitory ? $detail->studentDormitory->dormitoryDetail->name . " - Lantai " . $detail->studentDormitory->dormitoryDetail->level : 'N/A' }}</td>
                                </tr>                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" data-bs-toggle="modal"
        data-bs-target=".modal-rekam-photo">
            <i class="fas fa-camera"></i> Ambil Foto
        </button>
        <button class="btn btn-info" data-bs-toggle="modal"
        data-bs-target=".modal-rekam-signature">
            <i class="fas fa-file-signature"></i> Tanda Tangan
        </button>
        <button class="btn btn-outline-warning" id="btn-cetak-kts">
            <i class="fas fa-qrcode"></i> Cetak E-KTS
        </button>
        <button class="btn btn-warning" id="btn-cetak-kts">
            <i class="fas fa-print"></i> Cetak KTS
        </button>
    </div>
    <div class="card-footer">
        <ol>
            <li>Gunakan Webcam yang bagus, atau hubungkan kamera mirrorless menggunakan fitur webcam.</li>
            <li>Gunakan Aspek Rasio 16:9 atau minimal resolusi adalah 1280x720 (HD)</li>
            <li>Pastikan anda telah mengizinkan browser menggunakan webcam atau camera</li>
        </ol>
    </div>
</div>

<div class="modal fade modal-rekam-photo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-center">
                        <h5>Preview</h5>
                        <div id="webcam-container" style="position: relative; width: 480px; max-height: 270px;">
                            <div id="my_camera"></div>
                        </div>
                    </div>
                    <div class="mx-auto my-auto text-center">
                        <button class="btn btn-primary" onclick="take();" id="btnTake"><i class="fas fa-camera"></i> Take & Smile</button>
                        <button class="btn btn-info d-none" onclick="saveSnap();" id="btnSave"><i class="fas fa-camera"></i> Upload</button>
                        <div id="captureStatus" class="text-danger"></div>
                    </div>
                    <div class="text-center">
                        <h5>Result</h5>
                        <div id="results" class="mx-auto my-auto">Your captured image will appear here...</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade modal-rekam-signature" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Tanda Tangan Siswa</h5>
                <div id="signpad"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

{{-- Take Photo JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>
    async function setupWebcam() {
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const videoDevices = devices.filter(device => device.kind === 'videoinput');
            if (videoDevices.length === 0) {
                showSwal('warning', 'Tidak ada kamera yang terdeteksi.', false);
                return;
            }

            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            const videoTrack = stream.getVideoTracks()[0];
            const settings = videoTrack.getSettings();

            const aspectRatio = settings.width / settings.height;

            // Tentukan konfigurasi berdasarkan aspect ratio
            if (Math.abs(aspectRatio - 16 / 9) < Math.abs(aspectRatio - 4 / 3)) {
                setWebcamConfig16_9();
            } else {
                setWebcamConfig4_3();
            }

            // Hentikan stream setelah selesai mendeteksi
            videoTrack.stop();

        } catch (error) {
            $('.modal-rekam-photo').modal('hide');
            console.error('Gagal mendeteksi kamera:', error);
            showSwal('error', 'Gagal mendeteksi kamera.', false);
        }
    }

    function setWebcamConfig16_9() {
        Webcam.set({
            width: 480,
            height: 270,
            dest_width: 480,
            dest_height: 270,
            crop_width: 202,
            crop_height: 270,
            image_format: 'jpeg',
            jpeg_quality: 100,
            force_flash: false,
        });
        console.log("Webcam configured for 16:9");
    }

    function setWebcamConfig4_3() {
        Webcam.set({
            width: 460,
            dest_width: 460,
            dest_height: 345,
            crop_width: 259,
            crop_height: 345,
            image_format: 'jpeg',
            jpeg_quality: 100,
            force_flash: false,
        });
        console.log("Webcam configured for 4:3");
    }

    $('.modal-rekam-photo').on('show.bs.modal', async function (e) {
        $('#captureStatus').html('');
        $('#btnSave').addClass('d-none');
        await setupWebcam();
        Webcam.attach('#my_camera');
        Webcam.on('error', function(err) {
            $('.modal-rekam-photo').modal('hide');
            console.error('Webcam error:', err);
            showSwal('warning', 'Gagal mengakses kamera. Pastikan Anda memberikan izin.', false);
        });
    });

    $('.modal-rekam-photo').on('hide.bs.modal', function (e) {
        $('#captureStatus').html('');
        Webcam.reset();
    });

    function take() {
        Webcam.snap(function(data_uri) {
            document.getElementById('results').innerHTML = '<img src="' + data_uri + '" class="img-fluid img-thumbnail" style="max-width:-webkit-fill-available; max-height: 375px;" id="imagePreview"/>';
            $('#btnSave').removeClass('d-none');
        });
    }

    function saveSnap() {
        var imageUri = $('#imagePreview').attr('src');
        $.ajax({
            url: "{{ route('staff.master-student.kts.save-photo') }}",
            type: 'POST',
            data: {
                image: imageUri,
                userId: '{{ $detail->id }}',
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                $('#btnTake').addClass('disabled');
                $('#btnSave').addClass('disabled');
                $('#captureStatus').html('Saving your photo, Please Wait .... ');
            },
            success: function(response) {
                $('.modal-rekam-photo').modal('hide');
                showSwal('success', 'Foto berhasil direkam.', true);
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    window.location.href = '{{ route('login') }}';
                }
                $('.modal-rekam-photo').modal('hide');
                showSwal('error', 'Gagal merekam foto.', false);
            }
        });
    }
</script>


{{-- Sign Pad JS --}}
<script src="{{ asset('assets/js/signpad.js') }}"></script>
<script>
    $('#signpad').SignPad({
        // width/height of the signature pad
        width       : 470,
        height      : 200,
        lineColor   : '#000',
        lineWidth   : 5,
        canvasId    : 'signature-pad',
        
        // Post
        userId      : '{{ $detail->id }}',
        csrfToken   : '{{ csrf_token() }}',
        saveUrl     : "{{ route('staff.master-student.kts.save-signature') }}",

        // custom CSS classes
        styles      : {
            clearBtn  : "btn btn-sm btn-danger",
            undoBtn   : "btn btn-sm btn-warning d-none",
            saveBtn   : "btn btn-sm btn-primary",
        }
    });
</script>
@endpush