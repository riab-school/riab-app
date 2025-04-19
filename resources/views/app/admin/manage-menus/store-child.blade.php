@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Create or Update Child Menu</h5>
                <a href="{{ route('admin.manage-menu') }}" class="btn btn-outline-danger btn-sm m-0">
                    <i class="feather icon-chevron-left"></i>
                    Back
                </a>
                <div class="card-header-right">
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.manage-menu.store-child') }}" method="POST" onsubmit="return processData(this)">
                    @if($menu && $menu->id)
                    <input type="hidden" name="id" value="{{ $menu->id }}">
                    @endif
                    <input type="hidden" name="menu_id" value="{{ $parent_id }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $menu->title ?? '' }}" required>
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Route</label>
                        <input type="text" class="form-control @error('route') is-invalid @enderror" id="route" name="route" value="{{ $menu->route ?? '' }}" required>
                        @error('route')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Order</label>
                        <input type="text" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ $menu->order ?? '' }}" required>
                        @error('order')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mb-4 btf">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection