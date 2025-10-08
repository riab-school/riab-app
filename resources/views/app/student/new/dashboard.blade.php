@extends('_layouts.app-layouts.index')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/timeline.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/timeline/component.css') }}" />
@endpush

@section('content')
<div class="text-center">
    <h3>PSB Timeline</h3>
    <h4>Jalur <u>{{ $registration_method == 'invited' ? 'Undangan' : 'Reguler' }}</u></h4>
</div>
@if(!empty($events))
<div class="cd-timeline js-cd-timeline">
    <div class="cd-timeline__container">
        @foreach ($events as $event)
        <div class="cd-timeline__block js-cd-block">
            <div class="cd-timeline__img js-cd-img {{ $event['color'] }}">
                <i class="feather icon-calendar"></i>
            </div>
            <div class="cd-timeline__content card js-cd-content">
                <div class="card-body {{ $event['is_ongoing'] ? 'bg-success text-white rounded' : '' }}">
                    <h5 style="{{ $event['is_pass'] ? 'text-decoration: line-through;' : '' }}">{{ $event['title'] }}
                        <small class="text-muted"></small>
                    </h5>
                    <p class="mb-0">{{ $event['desc'] }}
                        @if (!empty($event['button']))
                            <br>
                            <a href="{{ $event['button']['url'] }}" class="btn btn-sm btn-warning mt-2">{{ $event['button']['text'] }}</a>
                        @endif
                    </p>
                    <span class="cd-timeline__date" style="{{ $event['is_pass'] ? 'text-decoration: line-through;' : '' }}">{{ $event['date'] }}</span>
                </div>
            </div>
        </div>    
        @endforeach
    </div>
</div>
@else
    <div class="alert alert-warning text-center" role="alert">
        <h4 class="alert-heading">Informasi!</h4>
        <p>Timeline belum tersedia. Silakan hubungi panitia.</p>
    </div>
@endif
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/timeline-master/js/modernizr.js') }}"></script>
    <script src="{{ asset('assets/plugins/timeline-master/js/hor-main.js') }}"></script>
    <script src="{{ asset('assets/plugins/timeline-master/js/ver-main.js') }}"></script>
    
    <script src="{{ asset('assets/js/pages/timeline/modernizr.custom.js') }}"></script>
    
@endpush

