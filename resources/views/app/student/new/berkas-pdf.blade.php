<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Berkas_{{ $student->nik_ktp }}</title>
    </head>
    <style>
        .page-break {
            page-break-after: always;
        }
        body {
            font-size: 11pt;
            font-family: Courier, Helvetica, sans-serif
            margin: 0px;
        }
        @page { 
            margin-top: 20px;
            margin-bottom: 2px;
            margin-left: 30px;
            margin-right: 30px;
        }
        .garis1{
            border-top:3px solid black;
            height: 2px;
            border-bottom:1px solid black;
            opacity: 1 !important;
            z-index: -99;
        }
        .box {
            border: 1px dotted black;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 2px;
            padding-bottom: 2px;
            margin-top: 100px;
        }
        td.header span{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16pt;
            vertical-align: middle;
        }
        td.header div{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            vertical-align: middle;
        }
        td.header span{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            vertical-align: middle;
        }
        .box ol {
            font-size: 10pt;
        }
    </style>
    <body>
        <img src="{{ Storage::disk('s3')->url($student->studentDocument->photo) }}" alt="" width="110px" height="165px" style="position: absolute; right: 2px; top: 110px; border: 1px solid black; border-style: dotted; padding: 2px;">
        <table>
            <tbody>
                <tr>
                    <td width="80px">
                        <img src="{{ public_path('assets/images/logo.png')}}" alt="" width="70px">
                    </td>
                    <td class="header">
                        <span>
                            <b>Kartu Peserta Ujian Penerimaan Santri Baru</b>
                        </span>
                        <div>
                            <b>{{ Config::get('app.school_name') }}</b>
                        </div>
                        <div>
                            <span>Tahun Ajaran {{ $psbConfig->tahun_ajaran }} / {{ $psbConfig->tahun_ajaran + 1 }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr class="garis1"/>
        
        <table cellpadding="1">
            <tbody>
                <tr>
                    <td width="50mm">Asal Sekolah</td>
                    <td width="2mm">:</td>
                    <td width="110mm"><b>{{ $student->studentOriginDetail->origin_school }}</b></td>
                </tr>
            </tbody>
        </table>
        <br />
        <br />
        <table cellpadding="1">
            <tbody>
                <tr>
                    <td width="50mm">No Ujian</td>
                    <td width="2mm">:</td>
                    <td width="110mm" style="font-size:16pt;"><b>{{ $psbHistory->class_focus == 'mipa' ? "A" : "G" }}-{{ $psbHistory->exam_number ?? '' }}</b></td>
                </tr>
                <tr>
                    <td>Jurusan Pilihan</td>
                    <td>:</td>
                    <td style="font-size:12pt;"><b>{{ $psbHistory->class_focus == 'mipa' ? "Matematika dan Ilmu Pengatahuan Alam (MIPA)" : "Keagamaan (MAK)" }}</b></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><b>{{ $student->name }}</b></td>
                </tr>
                <tr>
                    <td>Tempat Lahir</td>
                    <td>:</td>
                    <td>{{ $student->place_of_birth }}</td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ dateIndo($student->date_of_birth) }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $student->gender == 'male' ? 'Laki-Laki' : 'Perempuan' }}</td>
                </tr>
            </tbody>
        </table>
        <br />
        <h4><b>Waktu dan Tempat Pelaksanaan</b></h4>
        <table cellpadding="1">
            <tbody>
                <tr>
                    <td width="50mm">Tanggal Ujian</td>
                    <td width="2mm">:</td>
                    <td width="110mm" style="font-size:16pt;"><b>{{ dateIndo($psbHistory->exam_date) }}</b></td>
                </tr>
                <tr>
                    <td>Ujian Komputer / CAT</td>
                    <td>:</td>
                    @if(request()->registration_method == 'invited')
                    <td>Tidak ada ujian Komputer / CAT</td>
                    @else
                    <td><b>{{ $psbHistory->cat_room }} | {{ $psbHistory->cat_session }}</b></td>
                    @endif
                </tr>
                <tr>
                    <td>Wawancara Santri</td>
                    <td>:</td>
                    <td><b>{{ $psbHistory->interview_room }} | {{ $psbHistory->interview_session }}</b></td>
                </tr>
                @if(request()->registration_method !== "invited")
                <tr>
                    <td>Wawancara Orang Tua</td>
                    <td>:</td>
                    <td><b>{{ $psbHistory->parent_interview_room }} | {{ $psbHistory->parent_interview_session }}</b></td>
                </tr>
                @else
                <tr>
                    <td>Wawancara Orang Tua</td>
                    <td>:</td>
                    <td><b>Tidak ada wawancara dengan wali santri</b></td>
                </tr>
                @endif
            </tbody>
        </table>
        <br />
        <br />
        <table width="100%">
            <tbody>
                <tr>
                    <td width="450px"></td>
                    <td>
                        Aceh Besar, {{ dateIndo($student->created_at->format('Y-m-d')) }}
                        <br/>
                        Ketua Panitia
                        <br />
                        <br />
                        <br />
                        <img src="{{ Storage::disk('s3')->url($psbConfig->tanda_tangan_ketua_panitia) }}" alt="" width="230px" style="position: absolute; right: 500px; top: 680px">
                        <br />
                        <br />
                        <br />
                        <u><b>{{ $psbConfig->ketua_panitia }}</b></u>
                    </td>               
                </tr>       
            </tbody>
        </table>

        <div class="box">
            <p style="font-size: 10pt">Catatan : </p>
            <ol>
                <li>Calon santri wajib hadir 20 menit sebelum jadwal tes dilaksanakan</li>
                <li>Calon santri harap membawa:
                  <ul>
                      <li>Raport Asli</li>
                      <li>Sertifikat Prestasi Asli (Jika Ada)</li>
                      <li>Surat Keterangan (SK) Peringkat (Jika Ada)</li>
                  </ul>
                </li>
                <li>Calon santri dan wali santri wajib berpakaian rapi :
                  <ul>
                      <li>Putra : Celana Kain, Kemeja/koko/batik dan peci</li>
                      <li>Putri : Gamis atau Rok longgar, Baju minimal selutut, Jilbab Syar`i</li>
                  </ul>
                </li>
           </ol>
        </div>

        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($psbHistory->registration_number, 'C39', 1,20) }}" alt="barcode" width="50%" style="position: absolute; left: 2px; bottom: 15px;"/>
        <small style="position: absolute; right: 0px; bottom: 20px; font-size: 6pt;">Panitia Penerimaan Santri Baru</small>

        <div class="page-break"></div>

        <img src="{{ Storage::disk('s3')->url($student->studentDocument->photo) }}" alt="" width="110px" height="165px" style="position: absolute; right: 2px; top: 110px; border: 1px solid black; border-style: dotted; padding: 2px;" >

        <table>
            <tbody>
                <tr>
                    <td width="80px">
                        <img src="{{ public_path('assets/images/logo.png')}}" alt="" width="70px">
                    </td>
                    <td class="header">
                        <span>
                            <b>Kartu Pendaftaran Penerimaan Santri Baru</b>
                        </span>
                        <div>
                            <b>{{ Config::get('app.school_name') }}</b>
                        </div>
                        <div>
                            <span>Tahun Ajaran {{ $psbConfig->tahun_ajaran }} / {{ $psbConfig->tahun_ajaran + 1 }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr class="garis1"/>
        
        {{-- Section Data Peserta  --}}
        <table cellpadding="1">
            <tbody>
                <tr>
                    <td width="50mm">No Registrasi</td>
                    <td width="2mm">:</td>
                    <td width="110mm"><b>{{ $psbHistory->registration_number }}</b></td>
                </tr>
                <tr>
                    <td>No KTP</td>
                    <td>:</td>
                    <td><b>{{ $student->nik_ktp }}</b></td>
                </tr>
                <tr>
                    <td>NISN</td>
                    <td>:</td>
                    <td><b>{{ $student->nisn }}</b></td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>:</td>
                    <td><b>{{ $psbHistory->class_focus == 'mipa' ? "Matematika dan Ilmu Pengatahuan Alam (MIPA)" : "Keagamaan (MAK)" }}</b></td>
                </tr>
                <tr>
                    <td>Jalur Daftar</td>
                    <td>:</td>
                    <td><b>{{ request()->registration_method == "invited" ? "Undangan" : "Reguler / Umum" }}</b></td>
                </tr>
            </tbody>
        </table>
        <br />
        <br />
        <table cellpadding="1">
            <tr>
                <td width="50mm">Nama</td>
                <td width="2mm">:</td>
                <td width="160mm"><b>{{ $student->name }}</b></td>
            </tr>
            <tr>
                <td>Tempat Lahir</td>
                <td>:</td>
                <td>{{ $student->place_of_birth }}</td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td>{{ dateIndo($student->date_of_birth) }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $student->gender == 'male' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Anak Ke / Dari</td>
                <td>:</td>
                <td>Ke {{ $student->child_order }} Dari {{ $student->from_child_order }} Bersaudara</td>
            </tr>
            <tr>
                <td>Hobi</td>
                <td>:</td>
                <td>{{ $student->hobby }}</td>
            </tr>
            <tr>
                <td>Cita Cita</td>
                <td>:</td>
                <td>{{ $student->ambition }}</td>
            </tr>
        </table>
        <br />

        {{-- Section Alamat Peserta --}}
        <table cellpadding="1">
            <tr>
                <td width="50mm">Alamat</td>
                <td width="2mm">:</td>
                <td width="160mm">{{ $student->address }}</td>
            </tr>
        </table>
        @if($student->country == "idn")
        <table cellpadding="1" style="margin-left: 34px">
            <tr>
                <td width="48mm">Desa</td>
                <td width="2mm">:</td>
                <td width="100mm">{{ getVillage($student->village_id) }}</td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>:</td>
                <td>{{ getDistrict($student->district_id) }}</td>
            </tr>
            <tr>
                <td>Kabupaten</td>
                <td>:</td>
                <td>{{ getCity($student->city_id) }}</td>
            </tr>
            <tr>
                <td>Provinsi</td>
                <td>:</td>
                <td>{{ getProvince($student->province_id) }}</td>
            </tr>
            <tr>
                <td>Kode Pos</td>
                <td>:</td>
                <td>{{ $student->postal_code }}</td>
            </tr>
        </table>
        @endif
        <br />
        
        {{-- Section Data Asal Sekolah --}}
        <table cellpadding="1">
            <tr>
                <td width="50mm">Data Asal Sekolah</td>
                <td width="2mm">:</td>
                <td width="160mm">{{ $student->studentOriginDetail->origin_school_npsn }} - {{ $student->studentOriginDetail->origin_school }}</td>
            </tr>
        </table>
        <table cellpadding="1" style="margin-left: 34px">
            <tr>
                <td width="48mm">Alamat</td>
                <td width="2mm">:</td>
                <td width="100mm">{{ $student->studentOriginDetail->origin_school_address }}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>:</td>
                <td>{{ $student->studentOriginDetail->origin_school_category }}</td>
            </tr>
            <tr>
                <td>Tahun Lulus</td>
                <td>:</td>
                <td>{{ $student->studentOriginDetail->origin_school_graduate }}</td>
            </tr>
        </table>
        <br />

        {{-- Section Nama Orang Tua --}}
        <table cellpadding="1">
            <tr>
                <td width="50mm">Nama Orang Tua</td>
                <td width="2mm">:</td>
                <td width="160mm"></td>
            </tr>
        </table>
        <table cellpadding="1" style="margin-left: 34px">
            <tr>
                <td width="48mm">Ayah</td>
                <td width="2mm">:</td>
                <td width="100mm">{{ $student->studentParentDetail->dad_is_alive == false ? "Alm. " : "" }}{{ $student->studentParentDetail->dad_name }}</td>
            </tr>
            <tr>
                <td>Ibu</td>
                <td>:</td>
                <td>{{ $student->studentParentDetail->mom_is_alive == false ? "Almh. " : "" }}{{ $student->studentParentDetail->mom_name }}</td>
            </tr>
        </table>
        <br />

        {{-- Section Pekerjaan Orang Tua --}}
        <table cellpadding="1">
            <tr>
                <td width="50mm">Pekerjaan Orang Tua</td>
                <td width="2mm">:</td>
                <td width="160mm"></td>
            </tr>
        </table>
        <table cellpadding="1" style="margin-left: 34px">
            <tr>
                <td width="48mm">Ayah</td>
                <td width="2mm">:</td>
                <td width="100mm">{{ $student->studentParentDetail->dad_occupation }}</td>
            </tr>
            <tr>
                <td>Ibu</td>
                <td>:</td>
                <td>{{ $student->studentParentDetail->mom_occupation }}</td>
            </tr>
        </table>
        <br />

        {{-- Section No Telepon Orang Tua --}}
        <table cellpadding="1">
            <tr>
                <td width="50mm">No Telepon Orang Tua</td>
                <td width="2mm">:</td>
                <td width="160mm"></td>
            </tr>
        </table>
        <table cellpadding="1" style="margin-left: 34px">
            <tr>
                <td width="48mm">Ayah</td>
                <td width="2mm">:</td>
                <td width="100mm">{{ $student->studentParentDetail->dad_phone }}</td>
            </tr>
            <tr>
                <td>Ibu</td>
                <td>:</td>
                <td>{{ $student->studentParentDetail->mom_phone }}</td>
            </tr>
        </table>
        <br />

        {{-- Section Wali Santri --}}
        <table cellpadding="1">
            <tr>
                <td width="50mm">Wali Santri</td>
                <td width="2mm">:</td>
                <td width="160mm"></td>
            </tr>
        </table>
        <table cellpadding="1" style="margin-left: 34px">
            <tr>
                <td width="48mm">Nama</td>
                <td width="2mm">:</td>
                <td width="100mm">{{ $student->studentGuardianDetail->name }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td>{{ $student->studentGuardianDetail->relation_detail }}</td>
            </tr>
            <tr>
                <td>No Telepon</td>
                <td>:</td>
                <td>{{ $student->studentGuardianDetail->phone }}</td>
            </tr>
        </table>

        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($psbHistory->registration_number, 'C39', 1,20) }}" alt="barcode" width="50%" style="position: absolute; left: 2px; bottom: 15px;"/>
        <small style="position: absolute; right: 0px; bottom: 20px; font-size: 6pt;">Panitia Penerimaan Santri Baru</small>
    </body>
</html>