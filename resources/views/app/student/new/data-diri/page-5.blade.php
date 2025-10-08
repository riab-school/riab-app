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
                <form id="form-berkas" action="{{ route('student.new.data-diri.store-page-6') }}" method="POST" enctype="multipart/form-data" class="repeater">
                    @if(!$documents || !$documents->is_completed)
                    @csrf
                    @endif
                    <div>

                        <h3>Pas Photo</h3>
                        <section>
                            <div class="row row align-items-center">
                                <div class="col-md-6">
                                    <label>Upload Pas Photo <small class="text-danger"> *Wajib</small></label>
                                    <input type="file" class="form-control" id="photo" name="photo" onchange="initPreview('photo', 'photo-preview');" required accept="image/*">
                                    <small>Format: JPG, PNG. Max size: 1MB</small>
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

                        <h3>Surat Keterangan Rangking</h3>
                        <section>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label>Upload Berkas</label>
                                    <input type="file" class="form-control" id="rank_certificate" name="rank_certificate" accept="application/pdf">
                                    <small>Format: PDF. Max size: 2MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label>Silahkan Download Contoh Surat</label>
                                    <div class="">
                                        <a href="#" class="btn btn-outline-primary btn-sm">Download Contoh</a>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3>Surat Rekom Kepala Sekolah</h3>
                        <section>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label>Upload Berkas <small class="text-danger"> *Wajib</small></label>
                                    <input type="file" class="form-control" id="origin_head_recommendation" name="origin_head_recommendation" accept="application/pdf" required>
                                    <small>Format: PDF. Max size: 2MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label>Silahkan Download Contoh Surat</label>
                                    <div class="">
                                        <a href="#" class="btn btn-outline-primary btn-sm">Download Contoh</a>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3>Surat Keterangan Sehat</h3>
                        <section>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label>Upload Berkas <small class="text-danger"> *Wajib</small></label>
                                    <input type="file" class="form-control" id="certificate_of_health" name="certificate_of_health" accept="application/pdf" required>
                                    <small>Format: PDF. Max size: 2MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label>Silahkan Download Contoh Surat</label>
                                    <div class="">
                                        <a href="#" class="btn btn-outline-primary btn-sm">Download Contoh</a>
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
<script src="{{ asset('assets/js/plugins/jquery.repeater.min.js') }}"></script>

<script>

    $(document).ready(function () {
        $('#form-berkas').repeater({
            initEmpty: true,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: true
        })
    });
    
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
                photo: { required: true, extension: "jpg|jpeg|png", filesize: 1048576 },
                rank_certificate: { extension: "pdf", filesize: 2097152 },
                origin_head_recommendation: { required: true, extension: "pdf", filesize: 2097152 },
                certificate_of_health: { required: true, extension: "pdf", filesize: 2097152 },
            },
            messages: {
                photo: { required: "Pas foto wajib diunggah.", extension: "Hanya JPG/PNG.", filesize: "Maks 1 MB." },
                rank_certificate: { extension: "Hanya File PDF.", filesize: "Maks 1 MB." },
                origin_head_recommendation: { required: "Surat Rekomendasi Kepala Sekolah wajib diunggah.", extension: "Hanya PDF.", filesize: "Maks 2 MB." },
                certificate_of_health: { required: "Surat Keterangan Sehat wajib diunggah.", extension: "Hanya PDF.", filesize: "Maks 2 MB." },
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

