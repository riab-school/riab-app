@extends('_layouts.app-layouts.index') @push('styles')

@php
    $documents = $documents ?? null;
    $statusPhoto = getRejectedFile('photo');
    $statusCertificateOfHealth = getRejectedFile('certificate_of_health');
    $statusOriginHeadRecommendation = getRejectedFile('origin_head_recommendation');
    $statusCertificateOfLetter = getRejectedFile('certificate_of_letter');
    $statusReport11 = getRejectedFile('report_1_1');
    $statusReport12 = getRejectedFile('report_1_2');
    $statusReport21 = getRejectedFile('report_2_1');
    $statusReport22 = getRejectedFile('report_2_2');
@endphp

{{ getRejectedFile(NULL) }}

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
                        Dokumen dan berkas anda sudah diverifikasi, anda dapat melakukan perubahan data dengan menghubungi admin atau panitia.
                    </div>
                @endif
                <form id="form-berkas" action="{{ route('student.new.data-diri.store-page-5') }}" method="POST" enctype="multipart/form-data" onsubmit="return processData(this)">
                    @if(!$documents || !$documents->is_completed)
                        @csrf
                    @endif

                    <div class="table-responsive">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th>Jenis Dokumen</th>
                                    <th>Status</th>
                                    <th>File Dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- PAS FOTO --}}
                                <tr>
                                    <td>Pas Foto
                                        <div class="small">3x4 Background Merah/Biru</div>
                                    </td>
                                    <td class="text-danger">
                                        @if($statusPhoto)
                                            <span class="badge bg-danger">Ditolak</span><br>
                                            <small>{{ $statusPhoto->rejection_reason }}</small>
                                            <div class="small">Silakan upload ulang</div>
                                        @elseif($documents && $documents->photo && !$documents->is_completed)
                                            <span class="badge bg-info">Menunggu Verifikasi</span>
                                        @elseif($documents && $documents->is_completed)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            Wajib Upload
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$documents || !$documents->is_completed || $statusPhoto)
                                            <input type="file" name="photo" class="form-control mt-2" accept="image/*"
                                                {{ (!$documents || !$documents->photo || $statusPhoto) ? 'required' : '' }}>
                                            <small>Format: JPG, JPEG, PNG | Max: 1 MB</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($documents && $documents->photo)
                                            <a href="{{ Storage::disk('s3')->url($documents->photo) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                        @endif
                                    </td>
                                </tr>

                                {{-- SURAT KESEHATAN --}}
                                <tr>
                                    <td>Surat Keterangan Sehat
                                        <div class="small"><a href="#">Lihat Contoh</a></div>
                                    </td>
                                    <td class="text-danger">
                                        @if($statusCertificateOfHealth)
                                            <span class="badge bg-danger">Ditolak</span><br>
                                            <small>{{ $statusCertificateOfHealth->rejection_reason }}</small>
                                            <div class="small">Silakan upload ulang</div>
                                        @elseif($documents && $documents->certificate_of_health && !$documents->is_completed)
                                            <span class="badge bg-info">Menunggu Verifikasi</span>
                                        @elseif($documents && $documents->is_completed)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            Wajib Upload
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$documents || !$documents->is_completed || $statusCertificateOfHealth)
                                            <input type="file" name="certificate_of_health" class="form-control mt-2" accept="application/pdf"
                                                {{ (!$documents || !$documents->certificate_of_health || $statusCertificateOfHealth) ? 'required' : '' }}>
                                            <small>Format: PDF | Max: 2 MB</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($documents && $documents->certificate_of_health)
                                            <a href="{{ Storage::disk('s3')->url($documents->certificate_of_health) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                        @endif
                                    </td>
                                </tr>

                                {{-- SURAT REKOMENDASI KEPALA SEKOLAH --}}
                                <tr>
                                    <td>Surat Rekomendasi Kepala Sekolah
                                        <div class="small"><a href="#">Lihat Contoh</a></div>
                                    </td>
                                    <td class="text-danger">
                                        @if($statusOriginHeadRecommendation)
                                            <span class="badge bg-danger">Ditolak</span><br>
                                            <small>{{ $statusOriginHeadRecommendation->rejection_reason }}</small>
                                            <div class="small">Silakan upload ulang</div>
                                        @elseif($documents && $documents->origin_head_recommendation && !$documents->is_completed)
                                            <span class="badge bg-info">Menunggu Verifikasi</span>
                                        @elseif($documents && $documents->is_completed)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            Wajib Upload
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$documents || !$documents->is_completed || $statusOriginHeadRecommendation)
                                            <input type="file" name="origin_head_recommendation" class="form-control mt-2" accept="application/pdf"
                                                {{ (!$documents || !$documents->origin_head_recommendation || $statusOriginHeadRecommendation) ? 'required' : '' }}>
                                            <small>Format: PDF | Max: 2 MB</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($documents && $documents->origin_head_recommendation)
                                            <a href="{{ Storage::disk('s3')->url($documents->origin_head_recommendation) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                        @endif
                                    </td>
                                </tr>

                                {{-- SURAT KETERANGAN RANGKING --}}
                                <tr>
                                    <td>Surat Keterangan Rangking
                                        <div class="small"><a href="#">Lihat Contoh</a></div>
                                    </td>
                                    <td class="text-danger">
                                        @if($statusCertificateOfLetter)
                                            <span class="badge bg-danger">Ditolak</span><br>
                                            <small>{{ $statusCertificateOfLetter->rejection_reason }}</small>
                                            <div class="small">Silakan upload ulang</div>
                                        @elseif($documents && $documents->certificate_of_letter && !$documents->is_completed)
                                            <span class="badge bg-info">Menunggu Verifikasi</span>
                                        @elseif($documents && $documents->is_completed)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            Opsional
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$documents || !$documents->is_completed || $statusCertificateOfLetter)
                                            <input type="file" name="certificate_of_letter" class="form-control mt-2" accept="application/pdf"
                                                {{ ($statusCertificateOfLetter) ? 'required' : '' }}>
                                            <small>Format: PDF | Max: 2 MB</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($documents && $documents->certificate_of_letter)
                                            <a href="{{ Storage::disk('s3')->url($documents->certificate_of_letter) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                        @endif
                                    </td>
                                </tr>

                                {{-- RAPOR KELAS 7 SEMESTER 1 --}}
                                <tr>
                                    <td>Rapor Kelas 7 (Semester 1)</td>
                                    <td class="text-danger">
                                        @if($statusReport11)
                                            <span class="badge bg-danger">Ditolak</span><br>
                                            <small>{{ $statusReport11->rejection_reason }}</small>
                                            <div class="small">Silakan upload ulang</div>
                                        @elseif($documents && $documents->report_1_1 && !$documents->is_completed)
                                            <span class="badge bg-info">Menunggu Verifikasi</span>
                                        @elseif($documents && $documents->is_completed)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            Wajib Upload
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$documents || !$documents->is_completed || $statusReport11)
                                            <input type="file" name="report_1_1" class="form-control mt-2" accept="application/pdf"
                                                {{ (!$documents || !$documents->report_1_1 || $statusReport11) ? 'required' : '' }}>
                                            <small>Format: PDF | Max: 2 MB</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($documents && $documents->report_1_1)
                                            <a href="{{ Storage::disk('s3')->url($documents->report_1_1) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                        @endif
                                    </td>
                                </tr>

                                {{-- RAPOR KELAS 7 SEMESTER 2 --}}
                                <tr>
                                    <td>Rapor Kelas 7 (Semester 2)</td>
                                    <td class="text-danger">
                                        @if($statusReport12)
                                            <span class="badge bg-danger">Ditolak</span><br>
                                            <small>{{ $statusReport12->rejection_reason }}</small>
                                            <div class="small">Silakan upload ulang</div>
                                        @elseif($documents && $documents->report_1_2 && !$documents->is_completed)
                                            <span class="badge bg-info">Menunggu Verifikasi</span>
                                        @elseif($documents && $documents->is_completed)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            Wajib Upload
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$documents || !$documents->is_completed || $statusReport12)
                                            <input type="file" name="report_1_2" class="form-control mt-2" accept="application/pdf"
                                                {{ (!$documents || !$documents->report_1_2 || $statusReport12) ? 'required' : '' }}>
                                            <small>Format: PDF | Max: 2 MB</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($documents && $documents->report_1_2)
                                            <a href="{{ Storage::disk('s3')->url($documents->report_1_2) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                        @endif
                                    </td>
                                </tr>

                                {{-- RAPOR KELAS 8 SEMESTER 1 --}}
                                <tr>
                                    <td>Rapor Kelas 8 (Semester 1)</td>
                                    <td class="text-danger">
                                        @if($statusReport21)
                                            <span class="badge bg-danger">Ditolak</span><br>
                                            <small>{{ $statusReport21->rejection_reason }}</small>
                                            <div class="small">Silakan upload ulang</div>
                                        @elseif($documents && $documents->report_2_1 && !$documents->is_completed)
                                            <span class="badge bg-info">Menunggu Verifikasi</span>
                                        @elseif($documents && $documents->is_completed)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            Wajib Upload
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$documents || !$documents->is_completed || $statusReport21)
                                            <input type="file" name="report_2_1" class="form-control mt-2" accept="application/pdf"
                                                {{ (!$documents || !$documents->report_2_1 || $statusReport21) ? 'required' : '' }}>
                                            <small>Format: PDF | Max: 2 MB</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($documents && $documents->report_2_1)
                                            <a href="{{ Storage::disk('s3')->url($documents->report_2_1) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                        @endif
                                    </td>
                                </tr>

                                {{-- RAPOR KELAS 8 SEMESTER 2 --}}
                                <tr>
                                    <td>Rapor Kelas 8 (Semester 2)</td>
                                    <td class="text-danger">
                                        @if($statusReport22)
                                            <span class="badge bg-danger">Ditolak</span><br>
                                            <small>{{ $statusReport22->rejection_reason }}</small>
                                            <div class="small">Silakan upload ulang</div>
                                        @elseif($documents && $documents->report_2_2 && !$documents->is_completed)
                                            <span class="badge bg-info">Menunggu Verifikasi</span>
                                        @elseif($documents && $documents->is_completed)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            Wajib Upload
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$documents || !$documents->is_completed || $statusReport22)
                                            <input type="file" name="report_2_2" class="form-control mt-2" accept="application/pdf"
                                                {{ (!$documents || !$documents->report_2_2 || $statusReport22) ? 'required' : '' }}>
                                            <small>Format: PDF | Max: 2 MB</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($documents && $documents->report_2_2)
                                            <a href="{{ Storage::disk('s3')->url($documents->report_2_2) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                        @endif
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary {{ $documents && $documents->is_completed ? 'disabled' : '' }}">Upload Berkas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush

