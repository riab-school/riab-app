<div class="row mb-3">
    <div class="col-mb-12">
        <ul class="nav flex-column nav-pills rounded" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <li>
                <a class="nav-link text-start @if(request()->page == '1' || !request()->page) active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 1]) }}">
                    <div>Data Siswa</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->is_completed)
                    <span class="text-success fas fa-check"></span>
                    @elseif(auth()->user()->myDetail && auth()->user()->myDetail->is_rejected == NULL)
                    <span class="text-warning fas fa-spinner"></span>
                    @elseif(auth()->user()->myDetail && auth()->user()->myDetail->is_rejected)
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '2') active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 2]) }}">
                    <div>Data Asal Sekolah</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->studentOriginDetail && auth()->user()->myDetail->studentOriginDetail->is_completed)
                    <span class="text-success fas fa-check"></span>
                    @elseif(auth()->user()->myDetail && auth()->user()->myDetail->studentOriginDetail && auth()->user()->myDetail->studentOriginDetail->is_rejected == NULL)
                    <span class="text-warning fas fa-spinner"></span>
                    @elseif(auth()->user()->myDetail && auth()->user()->myDetail->studentOriginDetail && auth()->user()->myDetail->studentOriginDetail->is_rejected)
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '3') active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 3]) }}">
                    <div>Data Orang Tua</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->studentParentDetail && auth()->user()->myDetail->studentParentDetail->is_completed)
                    <span class="text-success fas fa-check"></span>
                    @elseif(auth()->user()->myDetail && auth()->user()->myDetail->studentParentDetail && auth()->user()->myDetail->studentParentDetail->is_rejected == NULL)
                    <span class="text-warning fas fa-spinner"></span>
                    @elseif(auth()->user()->myDetail && auth()->user()->myDetail->studentParentDetail && auth()->user()->myDetail->studentParentDetail->is_rejected)
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '4') active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 4]) }}">
                    <div>Data Wali</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->studentGuardianDetail && auth()->user()->myDetail->studentGuardianDetail->is_completed)
                    <span class="text-success fas fa-check"></span>
                    @elseif(auth()->user()->myDetail && auth()->user()->myDetail->studentGuardianDetail && auth()->user()->myDetail->studentGuardianDetail->is_rejected == NULL)
                    <span class="text-warning fas fa-spinner"></span>
                    @elseif(auth()->user()->myDetail && auth()->user()->myDetail->studentGuardianDetail && auth()->user()->myDetail->studentGuardianDetail->is_rejected)
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            
            <li>
                <a class="nav-link text-start @if(request()->page == '5') active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 5]) }}">
                    <div>Dokumen dan Berkas</div>
                    @if(auth()->user()->myDetail && auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->is_completed && empty(getRejectedFile(NULL)))
                    <span class="text-success fas fa-check"></span>
                    @elseif(auth()->user()->myDetail && auth()->user()->myDetail->studentDocument && getRejectedFile(NULL)->count() == 0 && auth()->user()->myDetail->studentDocument->is_completed == false)
                    <span class="text-warning fas fa-spinner"></span>
                    @elseif(auth()->user()->myDetail && auth()->user()->myDetail->studentDocument && getRejectedFile(NULL)->count() > 0)
                    <span class="text-danger fas fa-times"></span>
                    @endif
                </a>
            </li>
            <li>
                <a class="nav-link text-start @if(request()->page == '6') active @endif d-flex justify-content-between align-items-center" href="{{ route('student.new.data-diri', ['page' => 6]) }}">
                    <div>Prestasi</div>
                </a>
            </li>
        </ul>
        <div class="d-flex flex-column m-2">
            <p class="text-success fas fa-check"> Sudah diverifikasi</p> 
            <p class="text-warning fas fa-spinner"> Menunggu verifikasi</p> 
            <p class="text-danger fas fa-times"> Di tolak</p>
        </div>
    </div>
</div>
