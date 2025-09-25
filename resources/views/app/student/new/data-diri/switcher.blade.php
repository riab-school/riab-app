<div class="row mb-3">
    <div class="col-12">
        <ul class="nav flex-column nav-pills rounded" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <li>
                <a class="nav-link text-start @if(request()->page == '1' || !request()->page) active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 1]) }}">
                    <div>Data Siswa</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->is_completed)
                    <span class="text-success fas fa-check"></span>
                    @else
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '2') active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 2]) }}">
                    <div>Data Asal Sekolah</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->studentOriginDetail && auth()->user()->myDetail->studentOriginDetail->is_completed)
                    <span class="text-success fas fa-check"></span>
                    @else
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '3') active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 3]) }}">
                    <div>Data Orang Tua</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->studentParentDetail && auth()->user()->myDetail->studentParentDetail->is_completed)
                    <span class="text-success fas fa-check"></span>
                    @else
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '4') active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 4]) }}">
                    <div>Data Wali</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->studentGuardianDetail && auth()->user()->myDetail->studentGuardianDetail->is_completed)
                    <span class="text-success fas fa-check"></span>
                    @else
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '5') active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 5]) }}">
                    <div>Informasi Kesehatan</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->studentHealthDetail && auth()->user()->myDetail->studentHealthDetail->is_completed)
                    <span class="text-success fas fa-check"></span>
                    @else
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '6') active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 6]) }}">
                    <div>Dokumen dan Berkas Pendukung</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->is_completed)
                    <span class="text-success fas fa-check"></span>
                    @else
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            <li>
                <div class="nav-link text-start disabled">
                    <span class="text-success fas fa-check"></span> Sudah diverifikasi
                    <br>
                    <span class="text-danger fas fa-times"></span> Belum Selesai / Menunggu Verifikasi
                </div>
            </li>
        </ul>
    </div>
</div>
