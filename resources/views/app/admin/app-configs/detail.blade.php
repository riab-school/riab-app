@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Update Config</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.app-configs') }}" class="btn btn-outline-danger btn-sm m-0">
                        <i class="feather icon-chevron-left"></i>
                        Back
                    </a>
                    <form action="{{ route('admin.app-configs.reset') }}" method="POST" onsubmit="return processWithQuestion(event, this);">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" class="btn btn-outline-secondary btn-sm m-0"">Reset Default</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.app-configs.update') }}" method="POST" onsubmit="return processData(this)" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="form-group mb-3">
                        <label class="form-label">Key</label>
                        <input type="text" class="form-control" value="{{ $key }}" required disabled>
                    </div>
                    @if($is_file)
                    <div class="form-group mb-3">
                        <label class="form-label">File</label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('value') is-invalid @enderror" id="value" name="value" required>
                            <a href="{{ asset($value) }}" class="btn btn-outline-secondary" type="button">Lihat File</a>
                            @error('value')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    @else
                    <div class="form-group mb-3">
                        <label class="form-label">Value</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ $value }}" required>
                        @error('value')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    @endif
                    <button type="submit" class="btn btn-primary mb-4 btf">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection