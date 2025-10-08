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
                <h5>Prestasi</h5>
            </div>
            <div class="card-body">
                
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush

