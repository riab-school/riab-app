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
            margin: 8mm;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: Courier, sans-serif;
            }
            .content {
                padding: 5mm;
                margin: 10px auto;
                
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
                            Laporan Perizinan
                        </div>
                        <div style="font-size: 12pt;">
                            <b>{{ appSet('SCHOOL_NAME') }}</b>
                        </div>
                        <div style="font-size: 10pt;">
                            <b>{{ appSet('SCHOOL_ADDRESS') }}</b>
                        </div>
                        <div style="font-size: 10pt;">
                            <b>{{ appSet('SCHOOL_NSM') }} - {{ appSet('SCHOOL_NPSN') }}</b>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr class="garis1"/>
        @if($report_by == 'date')
        <p style="text-align: center; font-size: 12pt; font-weight: bold;">
            {{ $from_date }} s/d {{ $to_date }} | {{ $status == 'all' ? 'Semua Status' : ucfirst($status) }}
        </p>
        @else
        <div style="text-align: center; font-weight: bold;">
            <h4>
                Laporan Perizinan <br>
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
                    <th style="padding: 5px; font-size: 12pt;">Pemohon</th>
                    <th style="padding: 5px; font-size: 12pt;">Pemberi Izin</th>
                    <th style="padding: 5px; font-size: 12pt;">Dari Tanggal</th>
                    <th style="padding: 5px; font-size: 12pt;">Hingga Tanggal</th>
                    <th style="padding: 5px; font-size: 12pt;">Alasan</th>
                    <th style="padding: 5px; font-size: 12pt;">Di Jemput Oleh</th>
                    <th style="padding: 5px; font-size: 12pt;">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                
                @foreach ($permissions as $item)
                    <tr>
                        <td style="text-align: center;">{{ $i }}</td>
                        @if($report_by == 'date')
                        <td style="padding: 5px; text-align: center;">{{ $item->detail->studentDetail->nis }} - {{ $item->detail->studentDetail->nisn }}</td>
                        <td style="padding: 5px; text-align: center;">{{ $item->detail->studentDetail->name }}</td>
                        @endif
                        <td style="padding: 5px; text-align: center;">{{ ucfirst($item->requested_by) }}</td>   
                        <td style="padding: 5px; text-align: center;">{{ $item->approvedBy->staffDetail->name }}</td>
                        <td style="padding: 5px; text-align: center;">{{ dateIndoShort($item->from_date) }}</td>
                        <td style="padding: 5px; text-align: center;">{{ dateIndoShort($item->to_date) }}</td>
                        <td style="padding: 5px; text-align: center;">{{ $item->reason }}</td>
                        <td style="padding: 5px; text-align: center;">{{ $item->pickup_by }}</td>
                        <td style="padding: 5px; text-align: center;">
                            @if($item->status == 'rejected')
                            <div>
                                <b>Ditolak</b>
                            </div>
                            <div>
                                <b>Oleh : {{ $item->rejectedBy->staffDetail->name }}</b>
                            </div>
                            <div>
                                <b>Alasan : {{ $item->reject_reason }}</b>
                            </div>
                            @else
                            <div>
                                <b>{{ ucfirst($item->status) }}</b>
                            </div>
                            <div>
                                Keluar : <b>{{ $item->checked_out_at !== NULL ? dateIndoShort($item->checked_out_at) : '-' }}</b>
                            </div>
                            <div>
                                Kembali : <b>{{ $item->checked_in_at !== NULL ? dateIndoShort($item->checked_in_at) : '-' }}</b>
                            </div>
                            @endif
                        </td>
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