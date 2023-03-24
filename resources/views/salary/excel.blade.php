@php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-type: application/octet-stream");
header ("Content-Disposition: attachment; filename=Laporan-salary-staff-".strtolower($staff->name)."-periode-".ucwords($filter ?? 'All').".xls");
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
        <b>DATA SALARY STAFF</b>
    </div>

    <br>
    <table style="">
        <tr>
            <td width="100">Nama</td>
            <td colspan="3">: {{ $staff->name }}</td>
        </tr>
        <tr>
            <td width="100">Position Status</td>
            <td colspan="3">: {{ $staff->position->status }}</td>
        </tr>
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
                        Status
                    </center>
                </th>
                <th>
                    <center>
                        Total Jam Lembur
                    </center>
                </th>
                <th>
                    <center>
                        Gaji Lembur Perjam
                    </center>
                </th>
                <th>
                    <center>
                        Total Gaji Lembur
                    </center>
                </th>
                <th>
                    <center>
                        Gaji Perbulan
                    </center>
                <th>
                    <center>
                        Total Gaji
                    </center>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($salary as $item)
            <tr style="line-height: 1;">
                <td>
                    <center>
                        {{ $loop->iteration }}
                    </center>
                </td>
                <td>
                    <center>
                        {{ ucwords($item->periode) }}
                    </center>
                </td>
                <td>
                    <center>
                        <span class="badge {{ $item->status_gaji == 'sudah di ACC' ? 'badge-success' : 'badge-danger' }}">{{ $item->status_gaji ?? 'belum di ACC' }}</span>
                    </center>
                </td>
                <td>
                    <center>
                        {{ $item->jumlah_jam_lembur_periode . ' Jam' }}
                    </center>
                </td>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format($item->gaji_lembur_perjam, 0, ',', '.') }}
                    </center>
                </td>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format($item->jumlah_uang_lembur, 0, ',', '.') }}
                    </center>
                </td>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format($item->staff->position->salary ?? '', 0, ',', '.') }} {{ $item->staff->position->status == 'Staff' ? '/ Bln' : '/ Bln' }}
                    </center>
                </td>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format($item->total, 0, ',', '.') }}
                    </center>
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="7">Tidak ada data untuk ditampilkan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>