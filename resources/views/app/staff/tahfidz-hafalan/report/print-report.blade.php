<html>
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Courier, sans-serif;
        }
        .content {
            padding: 5mm;
            margin: 10px auto;
            
        }
        
        .page-break {
            page-break-after: always;
        }

        .garis1{
            border-top:3px solid black;
            height: 2px;
            border-bottom:1px solid black;
            opacity: 1 !important;
            z-index: -99;
        }

        .custom-bordered {
            border-collapse: collapse;
        }

        .custom-bordered, 
        .custom-bordered th, 
        .custom-bordered td {
            border: 1px solid black;
            font-size: 10pt;
        }

        @page {
            size: A4 landscape;
            margin: 5mm;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: Courier, sans-serif;
            }
            .content {
                padding: 5mm;
                margin: 5px auto;
                
            }
            .btn {
                display: none;
            }
        }
        
    </style>
</head>
<body>
    <div class="content">
        <table width="100%">
            <tbody>
                <tr>
                    <td width="5px">
                        <img src="{{ asset('assets/images/logo.png')}}" alt="" width="70px">
                    </td>
                    <td style="text-align: center;">
                        <div style="font-size: 15pt; font-weight: bold;">
                            Laporan Hafalan & Tahfidz
                        </div>
                        <div style="font-size: 12pt;">
                            <b>{{ appSet('SCHOOL_NAME') }}</b>
                        </div>
                        <div style="font-size: 10pt;">
                            <b>{{ appSet('SCHOOL_ADDRESS') }}</b>
                        </div>
                        <div style="font-size: 10pt;">
                            <b>NSM : {{ appSet('SCHOOL_NSM') }} <br>NPSN : {{ appSet('SCHOOL_NPSN') }}</b>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr class="garis1"/>
        @if($report_by == 'date')
        <p style="text-align: center; font-size: 12pt; font-weight: bold;">
            {{ $from_date }} s/d {{ $to_date }}
        </p>
        @else
        <div style="text-align: center; font-weight: bold;">
            <h4>
                Laporan Hafalan & Tahfidz <br>
                <u>{{ $studentData->name }}</u>
            </h4>
        </div>
        @endif
        <table width="100%" class="custom-bordered">
            <thead>
                <tr>
                    <th style="padding: 5px; font-size: 12pt;">No</th>
                    @if($report_by == 'date')
                    <th style="padding: 5px; font-size: 12pt;">NIS & NISN</th>
                    <th style="padding: 5px; font-size: 12pt;">Nama</th>
                    @endif
                    <th style="padding: 5px; font-size: 12pt;">Tanggal</th>
                    <th style="padding: 5px; font-size: 12pt;">Dari Surat</th>
                    <th style="padding: 5px; font-size: 12pt;">Ayat</th>
                    <th style="padding: 5px; font-size: 12pt;">Juz & Halaman</th>
                    <th style="padding: 5px; font-size: 12pt;">Point Tahsin</th>
                    <th style="padding: 5px; font-size: 12pt;">Point Tahfidz</th>
                    <th style="padding: 5px; font-size: 12pt;">Catatan</th>
                    <th style="padding: 5px; font-size: 12pt;">Tasmik Oleh</th>
                    <th style="padding: 5px; font-size: 12pt;">Bukti Setoran</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                
                @foreach ($achievements as $item)
                    <tr>
                        <td style="text-align: center;">{{ $i }}</td>
                        @if($report_by == 'date')
                        <td style="padding: 5px; text-align: center;">{{ $item->userDetail->studentDetail->nis }} - {{ $item->userDetail->studentDetail->nisn }}</td>
                        <td style="padding: 5px; text-align: center;">{{ $item->userDetail->studentDetail->name }}</td>
                        @endif
                        <td style="padding: 5px; text-align: center;">{{ $item->created_at->format('d-m-Y H:i:s') }}</td>
                        <td style="padding: 5px; text-align: center;">({{ $item->surah }}){{ $item->getSurahNameAttribute() }}</td>   
                        <td style="padding: 5px; text-align: center;">{{ $item->from_ayat }} s/d {{ $item->to_ayat }}</td>
                        <td style="padding: 5px; text-align: center;">{{ $item->ket_juz_halaman }}</td>
                        <td style="padding: 5px; text-align: center;">{{ $item->point_tahsin }}</td>
                        <td style="padding: 5px; text-align: center;">{{ $item->point_tahfidz }}</td>
                        <td style="padding: 5px; text-align: center;">{{ $item->note }}</td>
                        <td style="padding: 5px; text-align: center;">{{ $item->tasmikBy->staffDetail->name }}</td>
                        <td style="padding: 5px; text-align: center;">{!! $item->evidence ? '<img style="max-width: 150px;" src="'.Storage::disk('s3')->url($item->evidence).'"/>' : '-' !!}</td>
                    </tr>
                @php
                    $i++;
                @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>