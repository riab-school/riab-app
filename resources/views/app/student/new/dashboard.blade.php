@extends('_layouts.app-layouts.index')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/timeline.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/timeline/component.css') }}" />
@endpush

@section('content')
<div class="text-center">
    <h3>You'r PSB Timeline</h3>
    <h5>Tahun Ajaran - {{  request()->psb_config->tahun_ajaran ?? 'Tahun Ajaran Belum diatur' }} </h5>
</div>
<div class="cd-timeline js-cd-timeline">
    <div class="cd-timeline__container">
        <div class="cd-timeline__block js-cd-block">
            <div class="cd-timeline__img js-cd-img bg-c-green">
                <i class="feather icon-briefcase"></i>
            </div>
            <div class="cd-timeline__content card js-cd-content">
                <div class="card-body">
                    <h5>Timeline Heading</h5>
                    <p>Lorem Ipsum is simply dummy text of the printing and
                        typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s.</p>
                    <button class="btn btn-primary btn-sm m-0">Read
                        more</button>
                    <span class="cd-timeline__date">Jan 14</span>
                </div>
            </div>
        </div>

        <div class="cd-timeline__block js-cd-block">
            <div class="cd-timeline__img js-cd-img bg-c-purple">
                <i class="feather icon-image"></i>
            </div>
            <div class="cd-timeline__content card js-cd-content">
                <img class="card-img-top"
                    src="assets/images/gallery-grid/img-grd-gal-2.jpg"
                    alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting
                        text below as a natural lead-in to additional content.
                        This content is a little bit longer.</p>
                    <p class="card-text mb-0"><small class="text-muted">Last
                            updated 3 mins ago</small></p>
                    <div class="text-end">
                        <button class="btn btn-success btn-sm ms-2"><i
                                class="feather icon-arrow-right"></i>Read
                            more</button>
                        <button
                            class="btn btn-danger btn-sm ml-0">Close</button>
                    </div>
                    <span class="cd-timeline__date">Jan 18</span>
                </div>
            </div>
        </div>

        <div class="cd-timeline__block js-cd-block">
            <div class="cd-timeline__img  js-cd-img bg-c-red">
                <i class="feather icon-instagram"></i>
            </div>
            <div class="cd-timeline__content card js-cd-content">
                <div class="card-header">
                    <h5>Broadcast new blog by smith</h5>
                </div>
                <img src="assets/images/gallery-grid/img-grd-gal-4.jpg"
                    alt="Card image cap" class="img-fluid">
                <div class="card-body">
                    <p class="card-text">This is a wider card with supporting
                        text below as a natural lead-in to additional content.
                    </p>
                    <blockquote class="blockquote">
                        <p class="mb-2">Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit. Integer posuere erat a ante.</p>
                        <footer class="blockquote-footer">Someone famous in
                            <cite title="Source Title">Source Title</cite>
                        </footer>
                    </blockquote>
                    <span class="cd-timeline__date">Jan 24</span>
                </div>
            </div>
        </div>

        <div class="cd-timeline__block js-cd-block">
            <div class="cd-timeline__img js-cd-img bg-c-yellow">
                <i class="feather icon-film"></i>
            </div>
            <div class="cd-timeline__content card js-cd-content">
                <div class="ratio ratio-4x3">
                    <iframe class="embed-responsive-item"
                        src="https://www.youtube.com/embed/oD-lmrfPECA?rel=0"
                        allowfullscreen></iframe>
                </div>
                <div class="card-body">
                    <h5>Some video you like hear</h5>
                    <p>Lorem Ipsum is simply dummy text of the printing and
                        typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s.</p>
                    <button class="btn btn-primary btn-sm m-0">Read
                        more</button>
                    <span class="cd-timeline__date">Feb 14</span>
                </div>
            </div>
        </div>

        <div class="cd-timeline__block js-cd-block">
            <div class="cd-timeline__img js-cd-img bg-c-blue">
                <i class="feather icon-layers"></i>
            </div>
            <div class="cd-timeline__content card js-cd-content">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col">
                            <h2>954</h2>
                        </div>
                        <div class="col-auto text-end">
                            <h6 class="text-muted">New Order</h6>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <span class="d-block"><i
                                    class="fas fa-circle text-c-green f-10 m-r-10"></i>India</span>
                            <span class="d-block"><i
                                    class="fas fa-circle text-c-red f-10 m-r-10"></i>France</span>
                            <span class="d-block"><i
                                    class="fas fa-circle text-c-blue f-10 m-r-10"></i>Other</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="d-block"><i
                                    class="fas fa-circle text-c-yellow f-10 m-r-10"></i>United
                                states</span>
                            <span class="d-block"><i
                                    class="fas fa-circle text-c-purple f-10 m-r-10"></i>United
                                Kingdom</span>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height:20px;">
                        <div class="progress-bar bg-success rounded"
                            role="progressbar" style="width: 30%;"
                            aria-valuenow="30" aria-valuemin="0"
                            aria-valuemax="100">24%</div>
                        <div class="progress-bar bg-danger rounded"
                            role="progressbar" style="width: 25%;"
                            aria-valuenow="25" aria-valuemin="0"
                            aria-valuemax="100">12%</div>
                        <div class="progress-bar bg-primary rounded"
                            role="progressbar" style="width: 20%;"
                            aria-valuenow="20" aria-valuemin="0"
                            aria-valuemax="100">10%</div>
                        <div class="progress-bar bg-warning rounded"
                            role="progressbar" style="width: 15%;"
                            aria-valuenow="15" aria-valuemin="0"
                            aria-valuemax="100">8%</div>
                        <div class="progress-bar bg-info rounded"
                            role="progressbar" style="width: 25%;"
                            aria-valuenow="25" aria-valuemin="0"
                            aria-valuemax="100">35%</div>
                    </div>
                    <span class="cd-timeline__date">Feb 18</span>
                </div>
            </div>
        </div>

        <div class="cd-timeline__block js-cd-block">
            <div class="cd-timeline__img js-cd-img bg-c-red">
                <i class="feather icon-alert-triangle"></i>
            </div>
            <div class="cd-timeline__content js-cd-content js-cd-content">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Alert!.. Are you Login?</h4>
                    <p>Aww yeah, you successfully read this important alert
                        message. This example text is going to run a bit longer
                        so that you can see how spacing within an alert works
                        with this kind of
                        content.</p>
                    <hr>
                    <p class="mb-0">Whenever you need to, be sure to use margin
                        utilities to keep things nice and tidy.</p>
                </div>
                <span class="cd-timeline__date">Feb 26</span>
            </div>
        </div>

        <div class="cd-timeline__block js-cd-block">
            <div class="cd-timeline__img js-cd-img bg-c-purple">
                <i class="feather icon-file-text"></i>
            </div>
            <div class="cd-timeline__content card js-cd-content">
                <div class="card-header">
                    <h5>Some content hear</h5>
                </div>
                <div class="card-body">
                    <h3>hii h3</h3>
                    <p class="text-success mb-1">Duis mollis, est non commodo
                        luctus.</p>
                    <h6>hii h6</h6>
                    <p class="text-info mb-1">Maecenas sed diam eget risus.</p>
                    <ol>
                        <li>Lorem ipsum dolor sit amet</li>
                        <li>Consectetur adipiscing elit</li>
                        <li>Nulla volutpat aliquam velit
                            <ul>
                                <li>Phasellus iaculis neque</li>
                                <li>Purus sodales ultricies</li>
                            </ul>
                        </li>
                        <li>Faucibus porta lacus fringilla vel</li>
                    </ol>
                    <p class="text-warning mb-1">Etiam porta sem malesuada.</p>
                    <p class="text-danger mb-1">Donec ullamcorper nulla.</p>
                    <span class="cd-timeline__date">Feb 18</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/timeline-master/js/modernizr.js') }}"></script>
    <script src="{{ asset('assets/plugins/timeline-master/js/hor-main.js') }}"></script>
    <script src="{{ asset('assets/plugins/timeline-master/js/ver-main.js') }}"></script>
    
    <script src="{{ asset('assets/js/pages/timeline/modernizr.custom.js') }}"></script>
    
@endpush

