@extends('_layouts.app-layouts.index') @push('styles')

@php
    $documents = auth()->user()->myDetail->studentDocument ?? null;
@endphp
@section('content')
@include('app.student.new.data-diri.running-text')
<div class="row">
    <div class="col-md-2">
        @include('app.student.new.data-diri.switcher')
    </div>
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5>Dokumen & Berkas</h5>
            </div>
            <div class="card-body">
                @if($documents && $documents->is_completed)
                    <div class="alert alert-danger" role="alert">
                        Data dokumen dan berkas anda sudah diverifikasi, anda dapat melakukan perubahan data dengan menghubungi admin atau panitia.
                    </div>
                @endif
                <form id="form-berkas" action="{{ route('student.new.data-diri.store-page-6') }}" method="POST" enctype="multipart/form-data">
                    @if(!$documents || !$documents->is_completed)
                    @csrf
                    @endif
                    <div>
                        <h3>Pas Photo</h3>
                        <section>
                            <div class="row row align-items-center">
                                <div class="col-md-6">
                                    <label>Upload Berkas</label>
                                    <input type="file" class="form-control" id="photo" name="photo" onchange="initPreview('photo', 'photo-preview');" required accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label>Preview Pas Photo</label>
                                    <div id="photo-preview">
                                        <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->photo
                                        ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->photo)
                                        : asset('assets/images/sample-image/photo.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3>KTP / KIA</h3>
                        <section>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label>Upload Berkas</label>
                                    <input type="file" class="form-control" id="ktp_file" name="ktp_file" onchange="initPreview('ktp_file', 'ktp_file-preview');" required accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label>Preview KTP / KIA</label>
                                    <div id="ktp_file-preview">
                                        <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->ktp_file
                                        ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->ktp_file)
                                        : asset('assets/images/sample-image/ktp.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3>Kartu Keluarga</h3>
                        <section>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label>Upload Berkas</label>
                                    <input type="file" class="form-control" id="kk_file" name="kk_file" onchange="initPreview('kk_file', 'kk_file-preview');" required accept="image/*,application/pdf">
                                </div>
                                <div class="col-md-6">
                                    <label>Preview Kartu Keluarga</label>
                                    <div id="kk_file-preview">
                                        <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->kk_file
                                        ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->kk_file)
                                        : asset('assets/images/sample-image/kk.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3>Akte Kelahiran</h3>
                        <section>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label>Upload Berkas</label>
                                    <input type="file" class="form-control" id="akte_file" name="akte_file" onchange="initPreview('akte_file', 'akte_file-preview');" required accept="image/*,application/pdf">
                                </div>
                                <div class="col-md-6">
                                    <label>Preview Akte Kelahiran</label>
                                    <div id="akte_file-preview">
                                        <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->akte_file
                                        ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->akte_file)
                                        : asset('assets/images/sample-image/akte.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3>Kartu NISN</h3>
                        <section>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label>Upload Berkas</label>
                                    <input type="file" class="form-control" id="nisn_file" name="nisn_file" onchange="initPreview('nisn_file', 'nisn_file-preview');" required accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label>Preview Kartu NISN</label>
                                    <div id="nisn_file-preview">
                                        <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->nisn_file
                                        ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->nisn_file)
                                        : asset('assets/images/sample-image/nisn.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3>KTP Orang Tua & Wali</h3>
                        <section>
                            <div class="row gap-4">
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h6>KTP Ayah</h6>
                                            <input type="file" class="form-control" id="dad_ktp_file" name="dad_ktp_file" onchange="initPreview('dad_ktp_file', 'dad_ktp_file-preview');" @if(auth()->user()->myDetail->studentParentDetail && auth()->user()->myDetail->studentParentDetail->dad_is_alive) required @endif accept="image/*">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Preview KTP Ayah</label>
                                            <div id="dad_ktp_file-preview">
                                                <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->dad_ktp_file
                                                ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->dad_ktp_file)
                                                : asset('assets/images/sample-image/ktp.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h6>KTP Ibu</h6>
                                            <input type="file" class="form-control" id="mom_ktp_file" name="mom_ktp_file" onchange="initPreview('mom_ktp_file', 'mom_ktp_file-preview');" @if(auth()->user()->myDetail->studentParentDetail && auth()->user()->myDetail->studentParentDetail->mom_is_alive) required @endif accept="image/*">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Preview KTP Ibu</label>
                                            <div id="mom_ktp_file-preview">
                                                <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->mom_ktp_file
                                                ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->mom_ktp_file)
                                                : asset('assets/images/sample-image/ktp.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h6>KTP Wali</h6>
                                            <input type="file" class="form-control" id="guardian_ktp_file" name="guardian_ktp_file" onchange="initPreview('guardian_ktp_file', 'guardian_ktp_file-preview');" required accept="image/*">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Preview KTP Wali</label>
                                            <div id="guardian_ktp_file-preview">
                                                <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->guardian_ktp_file
                                                ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->guardian_ktp_file)
                                                : asset('assets/images/sample-image/ktp.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3>Kartu Lainnya</h3>
                        <section>
                            <div class="row gap-2">
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h6>BPJS</h6>
                                            <input type="file" class="form-control" id="bpjs" name="bpjs" onchange="initPreview('bpjs', 'bpjs-preview');" required accept="image/*">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Preview Kartu BPJS</label>
                                            <div id="bpjs-preview">
                                                <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->bpjs
                                                ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->bpjs)
                                                : asset('assets/images/sample-image/bpjs.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h6>KIS</h6>
                                            <input type="file" class="form-control" id="kis" name="kis" onchange="initPreview('kis', 'kis-preview');" accept="image/*">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Preview Kartu KIS</label>
                                            <div id="kis-preview">
                                                <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->kis
                                                ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->kis)
                                                : asset('assets/images/sample-image/kis.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h6>KIP</h6>
                                            <input type="file" class="form-control" id="kip" name="kip" onchange="initPreview('kip', 'kip-preview');" accept="image/*">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Preview Kartu KIP</label>
                                            <div id="kip-preview">
                                                <img src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->kip
                                                ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->kip)
                                                : asset('assets/images/sample-image/kip.jpg') }}" class="" alt="sample" style="max-width: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugins/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.steps.min.js') }}"></script>

<script>
    $(function () {
        const form = $("#form-berkas");

        @if(auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->is_completed)
            // Hapus masing masing field input dan jadikan col-md-12 untuk file previewnya
            form.find(".col-md-6:first-child").remove();
            form.find(".col-md-6:last-child").removeClass("col-md-6").addClass("col-md-12 text-center");
            // Disable semua input
            form.find("input").prop("disabled", true); // ubah ke true untuk disable semua input
        @else
            form.find("input").prop("disabled", false); // ubah ke false untuk enable semua input
        @endif

        // 🔹 Tambahkan method custom validator
        jQuery.validator.addMethod("filesize", function (value, element, param) {
            if (element.files.length === 0) {
                return true;
            }
            return this.optional(element) || (element.files[0].size <= param);
        }, "Ukuran file terlalu besar.");

        jQuery.validator.addMethod("extension", function (value, element, param) {
            if (value === "") {
                return true;
            }
            param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|pdf";
            return this.optional(element) || value.match(new RegExp("\\.(" + param + ")$", "i"));
        }, "Format file tidak diizinkan.");

        // 🔹 Setup validate
        form.validate({
            errorPlacement: function (error, element) {
                element.after(error);
            },
            rules: {
                photo: { required: true, extension: "jpg|jpeg|png", filesize: 2097152 },
                ktp_file: { required: true, extension: "jpg|jpeg|png", filesize: 2097152 },
                kk_file: { required: true, extension: "jpg|jpeg|png|pdf", filesize: 2097152 },
                akte_file: { required: true, extension: "jpg|jpeg|png|pdf", filesize: 2097152 },
                nisn_file: { required: true, extension: "jpg|jpeg|png", filesize: 2097152 },
                dad_ktp_file: { required: true, extension: "jpg|jpeg|png", filesize: 2097152 },
                mom_ktp_file: { required: true, extension: "jpg|jpeg|png", filesize: 2097152 },
                guardian_ktp_file: { required: true, extension: "jpg|jpeg|png", filesize: 2097152 },
                bpjs: { required: true, extension: "jpg|jpeg|png", filesize: 2097152 },
                kis: { extension: "jpg|jpeg|png", filesize: 2097152 },
                kip: { extension: "jpg|jpeg|png", filesize: 2097152 }
            },
            messages: {
                photo: { required: "Pas foto wajib diunggah.", extension: "Hanya JPG/PNG.", filesize: "Maks 2 MB." },
                ktp_file: { required: "KTP/KIA wajib diunggah.", extension: "Hanya JPG/PNG.", filesize: "Maks 2 MB." },
                kk_file: { required: "KK wajib diunggah.", extension: "Harus JPG/PNG/PDF.", filesize: "Maks 2 MB." },
                akte_file: { required: "Akte wajib diunggah.", extension: "Harus JPG/PNG/PDF.", filesize: "Maks 2 MB." },
                nisn_file: { required: "NISN wajib diunggah.", extension: "Hanya JPG/PNG.", filesize: "Maks 2 MB." },
                dad_ktp_file: { required: "KTP Ayah wajib diunggah.", extension: "Hanya JPG/PNG.", filesize: "Maks 2 MB." },
                mom_ktp_file: { required: "KTP Ibu wajib diunggah.", extension: "Hanya JPG/PNG.", filesize: "Maks 2 MB." },
                guardian_ktp_file: { required: "KTP Wali wajib diunggah.", extension: "Hanya JPG/PNG.", filesize: "Maks 2 MB." },
                bpjs: { required: "BPJS wajib diunggah.", extension: "Hanya JPG/PNG.", filesize: "Maks 2 MB." },
                kis: { extension: "Hanya JPG/PNG.", filesize: "Maks 2 MB." },
                kip: { extension: "Hanya JPG/PNG.", filesize: "Maks 2 MB." }
            }
        });

        // 🔹 Setup jQuery Steps
        form.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "fade",
            onStepChanging: function (event, currentIndex, newIndex) {
                return form.valid();
            },
            onFinishing: function (event, currentIndex) {
                if (form.find("input[type='file']").length === 0) {
                    showSwal("info", "Tidak ada berkas untuk diunggah.");
                    return;
                }
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                // if no input file is find just send alert
                if (form.find("input[type='file']").length === 0) {
                    showSwal("info", "Tidak ada berkas untuk diunggah.");
                    return;
                }
                // Disable the button to prevent multiple submits
                $("#form-berkas button").prop("disabled", true);
                // Submit the form
                $.LoadingOverlay('show');
                form.submit();
            }
        });
    });
</script>
<script>
    function initPreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        if (!input || !preview) return;

        preview.innerHTML = ""; // reset preview

        const files = input.files;
        if (!files || files.length === 0) return;

        const file = files[0]; // ambil file pertama

        const fileType = file.type;

        if (fileType.startsWith("image/")) {
            // preview gambar
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file); // ini URL sementara
            img.style.maxWidth = "200px";
            preview.appendChild(img);
        } else if (fileType === "application/pdf") {
            // preview PDF
            const embed = document.createElement("embed");
            embed.src = URL.createObjectURL(file);
            embed.type = "application/pdf";
            embed.width = "100%";
            embed.height = "200px";
            preview.appendChild(embed);
        } else {
            // fallback: hanya tampilkan nama file
            preview.textContent = "File: " + file.name;
        }
    }
</script>
@endpush

