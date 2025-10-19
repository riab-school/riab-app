@extends('_layouts.app-layouts.index')

@push('styles')
@endpush

@php
    $documents = auth()->user()->myDetail->studentDocument ?? null;
    $studentsAchievements = auth()->user()->myDetail->studentAchievementHistory
        ->sortBy('created_at')
        ->values();
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
                <h5>Prestasi</h5>
            </div>
            <div class="card-body">
                 @if($documents && $documents->is_completed)
                    <div class="alert alert-danger" role="alert">
                        Dokumen dan berkas anda sudah diverifikasi, anda dapat melakukan perubahan data dengan menghubungi admin atau panitia.
                    </div>
                @endif
                <form id="form-berkas" action="{{ route('student.new.data-diri.store-page-6') }}" method="POST" enctype="multipart/form-data" onsubmit="return processDataWithLoading(this)">
                    @if(!$documents || !$documents->is_completed)
                    @csrf
                    @endif

                    <div id="certificate-wrapper" data-delete-base="{{ route('student.new.data-diri.delete-certificate') }}">
                        @forelse($studentsAchievements as $index => $achievement)
                            <input type="hidden" name="id[]" value="{{ $achievement->id }}">
                            <div class="certificate-item border p-3 mb-3 rounded" data-achievement-id="{{ $achievement['id'] ?? '' }}">
                                <div class="mb-2 d-flex justify-content-between align-items-start gap-2">
                                    <div class="flex-grow-1">
                                        <label class="certificate-label fw-bold">Bukti Sertifikat #{{ $loop->iteration }}</label>
                                        <small class="text-danger">Tidak wajib melampirkan sertifikat</small>
                                        <div class="input-group">
                                            @if(!$documents || !$documents->is_completed)
                                            <input type="file" name="evidence[]" class="form-control" accept="application/pdf,image/*">
                                            @endif
                                            @if(!empty($achievement['evidence']))
                                            <a href="{{ Storage::disk('s3')->url($achievement['evidence']) }}" target="_blank" class="btn btn-primary ">
                                                Lihat File Saya
                                            </a>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="mt-2">
                                    <label>Detail / Keterangan Prestasi</label>
                                    <input type="text" name="detail[]" class="form-control"
                                        value="{{ $achievement['detail'] ?? '' }}"
                                        placeholder="Contoh: Juara 1 Lomba Sains" required {{ $documents && $documents->is_completed ? 'disabled' : '' }}>
                                </div>

                                <div class="mt-2 d-flex gap-2">
                                    @if(!$documents || !$documents->is_completed)
                                        @if(!empty($achievement['id']))
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-existing" 
                                                data-id="{{ $achievement['id'] }}">
                                                Hapus Permanen
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @empty
                            {{-- default one --}}
                            <input type="hidden" name="id[]" value="">
                            <div class="certificate-item border p-3 mb-3 rounded">
                                <div class="mb-2">
                                    <label class="certificate-label fw-bold">Bukti Sertifikat #1</label>
                                    <small class="text-danger">Tidak wajib melampirkan sertifikat</small>
                                    <input type="file" name="evidence[]" class="form-control" accept="application/pdf,image/*">
                                </div>

                                <div>
                                    <label>Detail / Keterangan Prestasi</label>
                                    <input type="text" name="detail[]" class="form-control" placeholder="Contoh: Juara 1 Lomba Sains" required>
                                </div>

                            </div>
                        @endforelse
                    </div>
                    @if(!$documents || !$documents->is_completed)
                    <button type="button" class="btn btn-success btn-sm mt-2" id="add-certificate">+ Tambah Sertifikat / Prestasi</button>
                    @endif
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary {{ $documents && $documents->is_completed ? 'disabled' : '' }}">Upload Sertifikat dan Prestasi</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@if(!$documents || !$documents->is_completed)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('certificate-wrapper');
    const addBtn = document.getElementById('add-certificate');
    const DELETE_BASE = wrapper.dataset.deleteBase;
    const CSRF_TOKEN = '{{ csrf_token() }}';
    
    // Create new item from template — robust (no cloning issues)
    function createNewItem(detail = '') {
        const el = document.createElement('div');
        el.className = 'certificate-item border p-3 mb-3 rounded';
        el.innerHTML = `
            <div class="mb-2">
                <label class="certificate-label fw-bold">Bukti Sertifikat</label>
                <small class="text-danger">Tidak wajib melampirkan sertifikat</small>
                <input type="file" name="evidence[]" class="form-control" accept="application/pdf,image/*">
            </div>
            <div class="mt-2">
                <label>Detail / Keterangan Prestasi</label>
                <input type="text" name="detail[]" class="form-control" placeholder="Contoh: Juara 1 Lomba Sains" required>
            </div>
            <div class="mt-2 d-flex gap-2">
                <button type="button" class="btn btn-danger btn-sm remove-certificate">Hapus Baris</button>
            </div>
        `;
        if (detail) {
            el.querySelector('input[name="detail[]"]').value = detail;
        }
        return el;
    }

    function updateLabels() {
        wrapper.querySelectorAll('.certificate-item').forEach((item, index) => {
            const lbl = item.querySelector('.certificate-label');
            if (lbl) lbl.textContent = `Bukti Sertifikat #${index + 1}`;
            // hide remove button if only one left
            const removeBtn = item.querySelector('.remove-certificate');
            const total = wrapper.querySelectorAll('.certificate-item').length;
            if (removeBtn) removeBtn.classList.toggle('d-none', total === 1);
        });
    }

    // Ensure at least one item
    if (!wrapper.querySelector('.certificate-item')) {
        wrapper.appendChild(createNewItem());
    }

    // Add new row
    addBtn.addEventListener('click', function() {
        const newItem = createNewItem();
        wrapper.appendChild(newItem);
        updateLabels();
        // focus on new detail input
        const inputs = newItem.querySelectorAll('input[type="text"]');
        if (inputs.length) inputs[0].focus();
    });

    // Delegate clicks inside wrapper
    wrapper.addEventListener('click', function(e) {
        // remove row (client-side only)
        if (e.target.classList.contains('remove-certificate')) {
            const row = e.target.closest('.certificate-item');
            if (row) row.remove();
            updateLabels();
            return;
        }

        // remove existing row (permanent) -> use AJAX DELETE
        if (e.target.classList.contains('remove-existing')) {

            const id = e.target.dataset.id;
            if (!id) showSwal('error', 'ID sertifikat tidak ditemukan');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang sudah dirubah atau hapus tidak dapat dikembalikan lagi.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    // call delete route
                    fetch(`${DELETE_BASE}/?id=${id}`, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json'
                        }
                    })
                    .then(async res => {
                        if (!res.ok) {
                            // try to get json message
                            let text = 'Gagal menghapus sertifikat';
                            try {
                                const j = await res.json();
                                text = j.message || text;
                            } catch (err) {}
                            throw new Error(text);
                        }
                        return res.json().catch(() => ({}));
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            showSwal('success', data.message, true);
                        } else {
                            throw new Error(data.message || 'Gagal menghapus sertifikat');
                        }
                    })
                    .catch(err => {
                        alert(err.message || 'Terjadi kesalahan saat menghapus sertifikat');
                    });

                    return;
                }
            });

            return false;
        }
    });

    // initial labels
    updateLabels();
});
</script>
@endpush
@endif