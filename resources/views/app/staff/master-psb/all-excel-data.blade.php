<html>
<head>
    <title>Laporan PSB</title>

    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <script>
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
                XLSX.writeFile(wb, fn || ('Report Pendaftaran Undangan.' + (type || 'xlsx')));
                
        }
    </script>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #000000;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
.button-success {
  background-color: #4CAF50;
  border: none;
  border-radius:5px;
  color: white;
  padding: 10px 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button-info {
  font-family: arial, sans-serif;
  background-color: #4c77af;
  border: none;
  border-radius:5px;
  color: white;
  padding: 10px 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>
</head>
<body>

<center>
    <a href="{{ url()->previous() }}" class="button-info">Kembali</a>
    <button onClick="ExportToExcel('xlsx');" class="button-success">Download To Excel</button>
    <br>
</center>
<hr>
<table style="width:100%;" id="tbl_exporttable_to_xls">
    <thead>
        <tr>
            <th>No</th>
            <th>Jalur</th>
            <th>Nama</th>
            <th>Jurusan Pilihan</th>
            <th>Nomor Ujian</th>
            <th>Nomor Telepon</th>
            <th>NIK KTP</th>
            <th>NISN</th>
            <th>File Photo</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Negara</th>
            <th>Alamat</th>
            <th>Provinsi</th>
            <th>Kabupaten</th>
            <th>Kecamatan</th>
            <th>Desa</th>
            <th>Kode Pos</th>
            <th>Anak Ke dari Bersaudara</th>
            <th>Anak Kandung ?</th>
            <th>Hobi</th>
            <th>Cita Cita</th>
            <th>||</th>
            <th>Status Ayah</th>
            <th>Nama Ayah</th>
            <th>No HP Ayah</th>
            <th>Pendidikan Ayah</th>
            <th>Pekerjaan Ayah</th>
            <th>Penghasilan Ayah</th>
            <th>Status Ibu</th>
            <th>Status Ayah dan Ibu</th>
            <th>Nama Ibu</th>
            <th>No HP Ibu</th>
            <th>Pendidikan Ibu</th>
            <th>Pekerjaan Ibu</th>
            <th>Penghasilan Ibu</th>
            <th>||</th>
            <th>Nama (Wali)</th>
            <th>Nomor Handphone (Wali)</th>
            <th>Negara Asal (Wali)</th>
            <th>Alamat (Wali)</th>
            <th>Provinsi (Wali)</th>
            <th>Kabupaten (Wali)</th>
            <th>Kecamatan (Wali)</th>
            <th>Desa (Wali)</th>
            <th>Kode Pos (Wali)</th>
            <th>Hubungan</th>
            <th>||</th>
            <th>Nama Asal Sekolah</th>
            <th>Alamat Asal Sekolah</th>
            <th>Kategori Asal Sekolah</th>
            <th>NPSN Asal Sekolah</th>
            <th>Tahun Lulus</th>
            <th>Surat Rekomendasi Kepala Sekolah</th>
            <th>Surat Keterangan Rangking</th>
            <th>Surat Keterangan Sehat</th>
            <th>Surat Bersedia Membiayai</th>
            <th>Raport Kelas 1 (Semeseter 1)</th>
            <th>Raport Kelas 1 (Semeseter 2)</th>
            <th>Raport Kelas 2 (Semeseter 1)</th>
            <th>Raport Kelas 2 (Semeseter 2)</th>
            <th>||</th>
            <th>Prestasi</th>
            <th>Tanggal Daftar</th>
            <th>||</th>
            <th>Tanggal Ujian</th>
            <th>Ruang CAT</th>
            <th>Sesi CAT</th>
            <th>Ruang Lisan</th>
            <th>Sesi Lisan</th>
            <th>Ruang Interview Wali</th>
            <th>Sesi Interview Wali</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 1;
        ?>
        @foreach ($data as $item)
            <tr>
                <td>{{$i}}</td>
                <td>{{$item['is_paid']}}</td>
                <td>{{$item['user']->studentDetail->name}}</td>
                <td>{{ $item['psb_data']->class_focus }}</td>
                <td>{{ $item['psb_data']->exam_number }}</td>
                <td>{{$item['user']->studentDetail->phone}}</td>
                <td>{{$item['user']->studentDetail->nik_ktp}}</td>
                <td>{{$item['user']->studentDetail->nisn}}</td>
                <td>{{$item['user']->studentDocument && $item['user']->studentDocument->photo !== NULL ? Storage::disk('s3')->url($item['user']->studentDocument->photo) : "Tidak Upload"}}</td>
                <td>{{$item['user']->studentDetail->place_of_birth}}</td>
                <td>{{$item['user']->studentDetail->date_of_birth}}</td>
                <td>{{$item['user']->studentDetail->gender == "male" ? 'Laki Laki' : 'Perempuan'}}</td>
                <td>{{$item['user']->studentDetail->country == "idn" ? "Indonesia" : "Luar Negeri"}}</td>
                <td>{{$item['user']->studentDetail->address}}</td>
                <td>{{$item['user']->studentDetail->country == "idn" ? getProvince($item['user']->studentDetail->province_id) : ""}}</td>
                <td>{{$item['user']->studentDetail->country == "idn" ? getCity($item['user']->studentDetail->city_id) : ""}}</td>
                <td>{{$item['user']->studentDetail->country == "idn" ? getDistrict($item['user']->studentDetail->district_id) : ""}}</td>
                <td>{{$item['user']->studentDetail->country == "idn" ? getVillage($item['user']->studentDetail->village_id) : ""}}</td>
                <td>{{$item['user']->studentDetail->postal_code}}</td>
                <td>Anak Ke {{$item['user']->studentDetail->child_order}} dari {{$item['user']->studentDetail->from_child_order}}</td>
                <td>{{$item['user']->studentDetail->is_biological == true ? "Ya": "Bukan"}}</td>
                <td>{{$item['user']->studentDetail->hobby}}</td>
                <td>{{$item['user']->studentDetail->ambition}}</td>
                
                <td>||</td>

                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->dad_is_alive ? "Masih" : "Meningggal"}}</td>
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->dad_name}}</td>
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->dad_phone}}</td>
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->dad_latest_education}}</td>
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->dad_occupation}}</td>
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->dad_income}}</td>
                
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->marital_status == 'married' ? "Menikah" : ($item['user']->studentParentDetail && $item['user']->studentParentDetail->marital_status == 'divorce' ? "Cerai Hidup" : "Cerai Mati")}}</td>
                
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->mom_is_alive == true ? "Masih" : "Meningggal"}}</td>
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->mom_name}}</td>
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->mom_phone}}</td>
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->mom_latest_education}}</td>
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->mom_occupation}}</td>
                <td>{{$item['user']->studentParentDetail && $item['user']->studentParentDetail->mom_income}}</td>
                
                <td>||</td>
                
                <td>{{$item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->name}}</td>
                <td>{{$item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->phone}}</td>
                <td>{{$item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->country == "idn" ? "Indonesia" : "Luar Negeri"}}</td>
                <td>{{$item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->address}}</td>
                <td>{{$item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->country == "idn" ? getProvince($item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->province_id) : ""}}</td>
                <td>{{$item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->country == "idn" ? getCity($item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->city_id) : ""}}</td>
                <td>{{$item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->country == "idn" ? getDistrict($item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->district_id) : ""}}</td>
                <td>{{$item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->country == "idn" ? getVillage($item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->village_id) : ""}}</td>
                <td>{{$item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->postal_code}}</td>
                <td>{{$item['user']->studentGuardianDetail && $item['user']->studentGuardianDetail->relation_detail}}</td>
                
                <td>||</td>

                <td>{{$item['user']->studentOriginDetail && $item['user']->studentOriginDetail->origin_school}}</td>
                <td>{{$item['user']->studentOriginDetail && $item['user']->studentOriginDetail->origin_school_address}}</td>
                <td>{{$item['user']->studentOriginDetail && $item['user']->studentOriginDetail->origin_school_category}}</td>
                <td>{{$item['user']->studentOriginDetail && $item['user']->studentOriginDetail->origin_school_npsn}}</td>
                <td>{{$item['user']->studentOriginDetail && $item['user']->studentOriginDetail->origin_school_graduate}}</td>
                <td>{{$item['user']->studentDocument && $item['user']->studentDocument->origin_head_recommendation !== NULL ? Storage::disk('s3')->url($item['user']->studentDocument && $item['user']->studentDocument->origin_head_recommendation) : 'Tidak Upload'}}</td>
                <td>{{$item['user']->studentDocument && $item['user']->studentDocument->rank_certificate !== NULL ? Storage::disk('s3')->url($item['user']->studentDocument && $item['user']->studentDocument->rank_certificate) : 'Tidak Upload'}}</td>
                <td>{{$item['user']->studentDocument && $item['user']->studentDocument->certificate_of_health !== NULL ? Storage::disk('s3')->url($item['user']->studentDocument && $item['user']->studentDocument->certificate_of_health) : 'Tidak Upload'}}</td>
                <td>{{$item['user']->studentDocument && $item['user']->studentDocument->letter_of_promise_to_financing !== NULL ? Storage::disk('s3')->url($item['user']->studentDocument && $item['user']->studentDocument->letter_of_promise_to_financing) : 'Tidak Upload'}}</td>
                <td>{{$item['user']->studentDocument && $item['user']->studentDocument->report_1_1 !== NULL ? Storage::disk('s3')->url($item['user']->studentDocument && $item['user']->studentDocument->report_1_1) : 'Tidak Upload'}}</td>
                <td>{{$item['user']->studentDocument && $item['user']->studentDocument->report_1_2 !== NULL ? Storage::disk('s3')->url($item['user']->studentDocument && $item['user']->studentDocument->report_1_2) : 'Tidak Upload'}}</td>
                <td>{{$item['user']->studentDocument && $item['user']->studentDocument->report_2_1 !== NULL ? Storage::disk('s3')->url($item['user']->studentDocument && $item['user']->studentDocument->report_2_1) : 'Tidak Upload'}}</td>
                <td>{{$item['user']->studentDocument && $item['user']->studentDocument->report_2_2 !== NULL ? Storage::disk('s3')->url($item['user']->studentDocument && $item['user']->studentDocument->report_2_2) : 'Tidak Upload'}}</td>

                <td>||</td>

                <td>
                    <?php $n = 1; ?>
                    @forelse ($item['user']->studentAchievementHistory ?? [] as $itemPrestasi)
                        <b>Prestasi{{ $n }}  : </b> {{$itemPrestasi->detail}}
                        <br>
                        <b>Sertifikat{{ $n }} : </b> {{$itemPrestasi->evidence !== NULL ? Storage::disk('s3')->url($itemPrestasi->evidence) : 'Tidak Upload'}}
                        <br>
                        <br>
                    <?php $n++ ?>
                    @empty
                        Tidak ada prestasi.
                    @endforelse
                </td>
                
                <td>{{$item['user']->created_at}}</td>
                <td>||</td>
                <td>{{ $item['psb_data']->studentInterviewRoom !== NULL ? $item['psb_data']->studentInterviewRoom->exam_date : '-'}}</td>
                <td>{{ $item['psb_data']->studentCatRoom !== NULL ? $item['psb_data']->studentCatRoom->room_name : '-'}}</td>
                <td>{{ $item['psb_data']->studentCatRoom !== NULL ? convertSesiToJam($item['psb_data']->studentCatRoom->room_session) : '-'}}</td>
                <td>{{ $item['psb_data']->studentInterviewRoom !== NULL ? $item['psb_data']->studentInterviewRoom->room_name : '-'}}</td>
                <td>{{ $item['psb_data']->studentInterviewRoom !== NULL ? convertSesiToJam($item['psb_data']->studentInterviewRoom->room_session) : '-'}}</td>
                <td>{{ $item['psb_data']->parentInterviewRoom !== NULL ? $item['psb_data']->parentInterviewRoom->room_name : '-'}}</td>
                <td>{{ $item['psb_data']->parentInterviewRoom !== NULL ? convertSesiToJam($item['psb_data']->parentInterviewRoom->room_session) : '-'}}</td>

            </tr>
            <?php $i++ ?>
        @endforeach
    </tbody>
</table>
</body>
</html>