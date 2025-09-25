<div class="row mb-3">
    <div class="col-12">
        <ul class="nav flex-column nav-pills rounded" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <li>
                <a class="nav-link text-start @if(request()->page == '1' || !request()->page) active @endif" href="{{ route('student.active.data-diri', ['page' => 1]) }}">
                    Data Siswa
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '2') active @endif" href="{{ route('student.active.data-diri', ['page' => 2]) }}">
                    Data Asal Sekolah
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '3') active @endif" href="{{ route('student.active.data-diri', ['page' => 3]) }}">
                    Data Orang Tua
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '4') active @endif" href="{{ route('student.active.data-diri', ['page' => 4]) }}">
                    Data Wali
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '5') active @endif" href="{{ route('student.active.data-diri', ['page' => 5]) }}">
                    Informasi Kesehatan
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '6') active @endif" href="{{ route('student.active.data-diri', ['page' => 6]) }}">
                    Dokumen dan Berkas Pendukung
                </a>
            </li>
        </ul>
    </div>
</div>
