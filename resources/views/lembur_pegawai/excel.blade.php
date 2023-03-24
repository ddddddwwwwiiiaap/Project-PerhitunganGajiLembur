@php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-type: application/octet-stream");
header ("Content-Disposition: attachment; filename=Laporan-Lembur-Pegawai-periode-".ucwords($filter ?? 'All').".xls");
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>Apurav - Report</title>
    <style>
        #master td {
            vertical-align: middle;

        }
    </style>
</head>

<body>
    <div style="text-align: center; font-size: 20px;">
        <b>DATA LEMBUR PEGAWAI</b>
    </div>

    <br>
    <table style="">
        <tr>
            <td>Periode</td>
            <td colspan="3">: {{ ucwords($filter ?? 'All') }}</td>
        </tr>
    </table>
    <br>

    <table border="1" style="font-size: 14px;width: 100%;">
        <thead>
            <tr style="background-color: royalblue">
                <th>
                    <center>
                        No
                    </center>
                </th>
                <th>
                    <center>
                        Periode
                    </center>
                </th>
                <th>
                    <center>
                        Kode Kategori Lembur
                    </center>
                </th>
                <th>
                    <center>
                        NIP
                    </center>
                </th>
                <th>
                    <center>
                        Nama staff
                    </center>
                </th>
                <th>
                    <center>
                        Mulai Lembur
                    </center>
                </th>
                <th>
                    <center>
                        Selesai Lembur
                    </center>
                </th>
                <th>
                    <center>
                        Jumlah Jam
                    </center>
                </th>
                <th>
                    <center>
                        Besaran Uang
                    </center>
                </th>
                <th>
                    <center>
                        Total
                    </center>
                </th>
                <th>
                    <center>
                        Tanggal Buat
                    </center>
                </th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($lembur_pegawai as $data)
            <tr style="line-height: 1;" id="hide{{$data->id}}">
                <td>
                    <center>{{$no++}}</center>
                </td>
                <td>
                    <center>{{$data->periode}}</center>
                </td>
                <td>
                    <center>{{$data->Kategori_lembur->kode_lembur}}</center>
                </td>
                <td>
                    <center>{{$data->staff->nip}}</center>
                </td>
                <td>
                    <center>{{$data->staff->name}}</center>
                </td>
                <td>
                    <center>{{$data->mulai_lembur}}</center>
                </td>
                <td>
                    <center>{{$data->selesai_lembur}}</center>
                </td>
                <td>
                    <center>{{$data->jumlah_jam}}</center>
                </td>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format($data->Kategori_lembur->besaran_uang ?? '', 0, ',', '.') }}
                    </center>
                </td>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format($data->jumlah_jam * $data->Kategori_lembur->besaran_uang ?? '', 0, ',', '.') }}
                    </center>
                </td>
                <td>
                    <center>{{$data->tanggal_lembur}}</center>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>