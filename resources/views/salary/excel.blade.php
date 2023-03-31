@php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-type: application/octet-stream");
header ("Content-Dispremium: attachment; filename=Laporan-salary-staff-".strtolower($staff->name).ucwords($filter ?? 'All').".xls");
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
        <b>TRANSPORT PELAYANAN WEEKEND BANKING KK POLRES, KK SCH, ATM & AKHIR BULANBL.</b>
    </div>

    <br>
    <table style="">
        <tr>
            <td width="100">Nama</td>
            <td colspan="3">: {{ $staff->name }}</td>
        </tr>
        <tr>
            <td width="100">Premium Status</td>
            <td colspan="3">: {{ $staff->premium->status }}</td>
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
                        <p style="text-align: center;">#</p>
                    </center>
                </th>
                <th>
                    <center>
                        <p style="text-align: center;">Periode</p>
                    </center>
                </th>
                <th>
                    <center>
                        <p style="text-align: center;">Status</p>
                    </center>
                </th>
                <th>
                    <center>
                        <p style="text-align: center;">Nama</p>
                    </center>
                </th>
                <th>
                    <center>
                        <p style="text-align: center;">Upah Pokok</p>
                    </center>
                </th>
                <th>
                    <center>
                        <p style="text-align: center;">Premium</p>
                    </center>
                </th>
                <th>
                    <center>
                        <p style="text-align: center;">Job Grade</p>
                    </center>
                </th>
                <th>
                    <center>
                        <p style="text-align: center;">Jml jam</p>
                    </center>
                </th>
                <th>
                    <center>
                        <p style="text-align: center;">1/173</p>
                    </center>
                </th>
                <th>
                    <center>
                        <p style="text-align: center;">Jumlah Upah Lembur</p>
                    </center>
                </th>
                <th>
                    <center>
                        <p style="text-align: center;">Pembulatan</p>
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
                        <span class="badge {{ $item->status_gaji == 'Verified' ? 'badge-success' : 'badge-danger' }}">{{ $item->status_gaji ?? 'Unverified' }}</span>
                    </center>
                </td>
                <td>
                    <center>
                        {{ $item->staff->name ?? '' }}
                    </center>
                </td>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format($item->staff->salary_staff ?? '', 0, ',', '.') }} {{ $item->staff->premium->status == 'Staff' ? '/ Bln' : '/ Bln' }}
                    </center>
                </td>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format($item->staff->premium->salary_premium ?? '', 0, ',', '.') }} {{ $item->staff->premium->status == 'Staff' ? '/ Bln' : '/ Bln' }}
                    </center>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format($item->staff->jobgrade->salary_jobgrade ?? '', 0, ',', '.') }} {{ $item->staff->premium->status == 'Staff' ? '/ Bln' : '/ Bln' }}
                    </center>
                </td>
                <td>
                    <center>
                        {{ $item->jumlah_jam_lembur_periode . ' Jam' }}
                    </center>
                </td>
                <td>
                    <center>
                        0.0058
                    </center>
                </td>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format($item->staff->jumlah * $item->jumlah_jam_lembur_periode * 0.0058 * 2 ?? '', 0, ',', '.') }}
                    </center>
                </td>
                <td>
                    <center>
                        {{ 'Rp. ' . number_format(round($item->staff->jumlah * $item->jumlah_jam_lembur_periode * 0.0058 * 2, -3), 0, ',', '.') }}
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