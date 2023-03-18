@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset ('css/sweetalert.css') }}">
@endsection
@section('content')
<div class="content-wrapper pb-3">
    <div class="content-header">
        <div class="container-fluid">
            <form>
                <div class="form-inline">
                    <a href="{{ route('kategori_lembur.create') }}" class="btn btn-default app-shadow d-none d-md-inline-block ml-auto">
                        <i class="fas fa-user-plus fa-fw"></i> Tambah
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="content pb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            Kategori Lembur
                            <span id="count" class="badge badge-danger float-right float-xl-right mt-1"></span>
                        </div>
                        <table id="itemtable" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 100px;">No</th>
                                    <th>
                                        <center>Kode Lembur</center>
                                    </th>
                                    <th>
                                        <center>Nama Position</center>
                                    </th>
                                    <th>
                                        <center>Nama Departement</center>
                                    </th>
                                    <th>
                                        <center>Besaran Uang</center>
                                    </th>
                                    <th>
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategori_lembur as $item)
                                <tr id="hide{{$item->id}}">
                                    <td>
                                        <center>
                                            {{ $loop->iteration }}
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            {{ $item->kode_lembur ?? '' }}
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            {{ $item->tb_position->name ?? '' }}
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            {{ $item->tb_departement->name ?? '' }}
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            {{ 'Rp. ' . number_format($item->besaran_uang ?? '', 0, ',', '.') }}
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <a href="{{ route('kategori_lembur.edit', $item->id) }}" class="btn btn-sm btn-warning app-shadow">
                                                <i class="fas fa-edit fa-fw"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" onclick="hapus({{ $item->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </center>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('kategori_lembur.create') }}" class="btn btn-lg rounded-circle btn-primary btn-fly d-block d-md-none app-shadow">
    <span><i class="fas fa-user-plus fa-sm align-middle"></i></span>
</a>

@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/sweetalert-dev.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script>
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
                        url: "{{URL::to('/kategori_lembur/destroy')}}",
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