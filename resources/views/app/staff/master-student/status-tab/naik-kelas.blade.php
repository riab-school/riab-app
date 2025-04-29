{{-- Naik Kelas --}}
<div class="tab-pane fade" id="pills-naik-kelas" role="tabpanel" aria-labelledby="pills-naik-kelas-tab">
    <h5>Naik Kelas</h5>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="card rounded-0">
                <div class="card-header">
                    <h5>Tahun Ajaran Asal | <span class="text-danger">{{ session()->get('tahun_ajaran_aktif') }}/{{ session()->get('tahun_ajaran_aktif') + 1 }}</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="filter_grade_from_1">Tingkat / Grade</label>
                            <select name="filter_grade_from_1" id="filter_grade_from_1" class="form-control">
                                <option value="">Pilih Tingkat</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="filter_classroom_from_1">Kelas</label>
                            <select name="filter_classroom_from_1" id="filter_classroom_from_1" class="form-control">
                                <option value="" disabled>Silahkan Pilih Tingkat Dulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableFrom1" class="table table-sm table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card rounded-0">
                <div class="card-header">
                    <h5>Tahun Ajaran Tujuan | <span class="text-danger">{{ session()->get('tahun_ajaran_aktif') + 1 }}/{{ session()->get('tahun_ajaran_aktif') + 2 }}</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="filter_grade_to_1">Tingkat / Grade</label>
                            <select name="filter_grade_to_1" id="filter_grade_to_1" class="form-control">
                                <option value="">Pilih Tingkat</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="filter_classroom_to_1">Kelas</label>
                            <select name="filter_classroom_to_1" id="filter_classroom_to_1" class="form-control">
                                <option value="" disabled>Silahkan Pilih Tingkat Dulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableTo1" class="table table-sm table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>