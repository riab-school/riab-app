<li data-username="animations" class="nav-item">
    <a href="{{ route('student.home.new') }}" class="nav-link">
        <span class="pcoded-micon">
            <i class="feather icon-home"></i>
        </span>
        <span class="pcoded-mtext">Dashboard</span>
    </a>
</li>

@if(request()->registration_history->is_exam_pass == NULL)
    @if(request()->registration_method !== 'invited')
    <li data-username="animations" class="nav-item">
        <a href="{{ route('student.payment.new') }}" class="nav-link">
            <span class="pcoded-micon">
                <i class="feather icon-tag"></i>
            </span>
            <span class="pcoded-mtext">Pembayaran PSB</span>
        </a>
    </li>
    @endif

    <li data-username="animations" class="nav-item">
        <a href="{{ route('student.new.data-diri') }}" class="nav-link">
            <span class="pcoded-micon">
                <i class="feather icon-align-justify"></i>
            </span>
            <span class="pcoded-mtext">Data & Identitas</span>
        </a>
    </li>

    {{-- <li data-username="animations" class="nav-item">
        <a href="{{ route('student.new.cetak-berkas') }}" class="nav-link">
            <span class="pcoded-micon">
                <i class="feather icon-printer"></i>
            </span>
            <span class="pcoded-mtext">Cetak Berkas dan Kartu</span>
        </a>
    </li> --}}

    <li data-username="animations" class="nav-item">
        <a href="{{ route('student.new.announcement') }}" class="nav-link">
            <span class="pcoded-micon">
                <i class="fas fa-bullhorn"></i>
            </span>
            <span class="pcoded-mtext">Pengumuman</span>
        </a>
    </li>
@else
    <li data-username="animations" class="nav-item">
        <a href="{{ route('student.new.announcement') }}" class="nav-link">
            <span class="pcoded-micon">
                <i class="fas fa-bullhorn"></i>
            </span>
            <span class="pcoded-mtext">Pengumuman</span>
        </a>
    </li>
@endif