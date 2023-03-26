@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset ('css/sweetalert.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.6-rc.1/dist/css/select2.min.css">
@endsection
@section('content')
<div class="content-wrapper pb-3">
    <div class="content pb-5 pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h3 class="card-title back-top" style="margin-top: 5px;">
                                <a href="{{ route('salary.index') }}" title="Kembali" data-toggle="tooltip" data-placement="right" class="btn text-muted">
                                    <i class="fa fa-arrow-left fa-fw"></i></span>
                                </a>
                            </h3>
                            <div class="float-left offset-5 pt-1">
                                <span class="d-none d-md-block d-lg-block">{{ $title ?? '' }}</span>
                            </div>
                            <div class="float-right row">
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
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="table no-border header-table mb-0 ml-2 mt-2">
                            <tr style="line-height: 1px;">
                                <td width="100">Nama</td>
                                <td width="10" class="text-center">:</td>
                                <td>{{ $staff->name }}</td>
                            </tr>
                            <tr style="line-height: 1px;">
                                <td width="100">Position Status</td>
                                <td width="10" class="text-center">:</td>
                                <td>{{ $staff->position->status }}</td>
                            </tr>
                            <tr style="line-height: 1px;">
                                <td>Periode</td>
                                <td>:</td>
                                <td>{{ ucwords($filter ?? 'All') }}</td>
                            </tr>
                        </table>
                        <div class="table-responsive">
                            <div class="card-body p-3">
                                <table class="table table-bordered mb-0" style="font-size: 14px;">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>
                                                <center>
                                                    #
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
                                            <th>
                                                <center>
                                                    Persetujuan
                                                </center>
                                            </th>
                                        <tr>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @forelse ($salary as $item)
                                        <tr style="line-height: 1;">
                                            <td class="text-center">
                                                <a href="#" class="text-secondary nav-link p-0" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)" onClick="hapus({{$item->id}})">
                                                        <i class="far fa-trash-alt mr-2"></i> Hapus
                                                    </a>
                                                </div>
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
                                            <td>
                                                <center>
                                                <a href="{{ route('salary.statusgaji', $item->id) }}" class="btn btn-sm btn-danger" title="Belum Lunas" data-toggle="tooltip" data-placement="right">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                    <a href="{{ route('salary.statusgaji', $item->id) }}" class="btn btn-sm btn-success" title="Lunas" data-toggle="tooltip" data-placement="right">
                                                        <i class="fas fa-check"></i>
                                                    </a>

                                                </center>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center" colspan="9">Tidak ada data untuk ditampilkan</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">

                            <div class="text-right">
                                @if (!empty($filter))
                                <a href="{{ route('salary.export.excel', [$staff->id, $filter]) }}" class="btn btn-success btn-sm" id="export-excel">
                                    <i class="fa fa-file-excel-o fa-fw"></i> Export Excel
                                </a>
                                @else
                                <a href="{{ route('salary.export.excel', [$staff->id, 'all']) }}" class="btn btn-success btn-sm" id="export-excel">
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
</div>

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
                        url: "{{URL::to('/salary/destroyDetail')}}",
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