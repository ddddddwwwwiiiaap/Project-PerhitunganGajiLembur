@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset ('css/sweetalert.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.6-rc.1/dist/css/select2.min.css">
@endsection
@section('content')
<div class="content-wrapper pb-3">
    <div class="content pb-5 pt-3">
        <div class="container-fluid">
            <form>
                <div class="form-inline">
                    <div class="input-group app-shadow">
                        <div class="input-group-append">
                            <div class="input-group-text bg-white border-0">
                                <span><i class="fa fa-search"></i> </span>
                            </div>
                        </div>
                        <input type="search" placeholder="Search" aria-label="Search..." class="form-control input-flat border-0" id="search">
                    </div>
                    <a href="{{ route('lembur_pegawai.create') }}" class="btn btn-default app-shadow d-none d-md-inline-block ml-auto">
                        <i class="fas fa-user-plus fa-fw"></i> Tambah
                    </a>
                </div>
            </form>
        </div>
        </br>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="form-inline">
                            <form action="{{ url()->current() }}">
                                <div class="input-group">
                                    <select name="filter" class="form-control input-sm select2">
                                        <option value="">Tampilkan semua</option>
                                        @if (!empty($filter))
                                        <option value="all">SHOW ALL</option>
                                        @endif
                                        @foreach ($periode as $item)
                                        <option value="{{ $item->periode }}" {{ $item->periode == old('filter', $filter) ? 'selected':'' }}>{{ strtoupper($item->periode) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append ">
                                        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table no-border header-table mb-0 ml-2 mt-2">
                        <tr style="line-height: 1px;">
                            <td width="100">Periode</td>
                            <td width="10" class="text-center">:</td>
                            <td>{{ ucwords($filter ?? 'All') }}</td>
                        </tr>
                    </table>
                    <div class="table-responsive">
                        <div class="card-body p-3">
                            <table id="datatable" class="table table-bordered mb-0" style="font-size: 14px;">
                                <thead>
                                    <tr class="bg-light">
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
                                        <th>
                                            <center>
                                                Aksi
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
                                        <td>
                                            <center>
                                                <a href="{{ route('lembur_pegawai.edit', $data->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="hapus({{$data->id}})">
                                                    <i class="fas fa-trash"></i>
                                            </center>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            @if (!empty($filter))
                            <a href="{{ route('lembur_pegawai.export.excel', ['filter' => $filter]) }}" class="btn btn-success btn-sm" id="export-excel">
                                <i class="fa fa-file-excel-o fa-fw"></i> Export Excel
                            </a>
                            @else
                            <a href="{{ route('lembur_pegawai.export.excel', ['filter' => 'all']) }}" class="btn btn-success btn-sm" id="export-excel">
                                <i class="fa fa-file-excel-o fa-fw"></i> Export Excel
                            </a>
                            @endif
                        </div>
                    </div>
                    <div id="loading"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('lembur_pegawai.create') }}" class="btn btn-lg rounded-circle btn-primary btn-fly d-block d-md-none app-shadow">
    <span><i class="fas fa-user-plus fa-sm align-middle"></i></span>
</a>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.6-rc.1/dist/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/sweetalert-dev.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
@include('alert.mk-notif')
<script>
    $('.select2').select2({
        placeholder: 'Periode..'
    });
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('#export-excel').on("click", function() {
        $(this).addClass('disabled');
        setTimeout(RemoveClass, 1000);
    });

    function RemoveClass() {
        $('#export-excel').removeClass("disabled");
    }

    function hapus(id) {
        swal({
                title: 'Yakin.. ?',
                text: "Data anda akan dihapus. Tekan tombol yes untuk melanjutkan.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{URL::to('/lembur_pegawai/destroy')}}",
                        data: "id=" + id,
                        success: function(data) {
                            swal("Deleted", data.message, "success");
                            $("#count").html(data.count);
                            $("#hide" + id).hide(300);
                        }
                    });

                } else {
                    swal("Canceled", "Anda Membatalkan! :)", "error");
                }
            });
    }
</script>
@endsection