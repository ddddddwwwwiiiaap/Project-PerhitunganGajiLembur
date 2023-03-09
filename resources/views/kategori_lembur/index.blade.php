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
                    <div class="input-group app-shadow">
                        <div class="input-group-append">
                            <div class="input-group-text bg-white border-0">
                                <span><i class="fa fa-search"></i> </span>
                            </div>
                        </div>
                        <input type="search" placeholder="Search" aria-label="Search..." class="form-control input-flat border-0" id="search">
                    </div>
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
                        <table id="datatable" class="table table-hover table-striped">
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
                                @php $no = 1; @endphp
                                @foreach($kategori_lembur as $data)
                                <tr id="hide{{$data->id}}">
                                    <td>
                                        <center>{{$no++}}</center>
                                    </td>
                                    <td>
                                        <center>{{$data->kode_lembur}}</center>
                                    </td>
                                    <td>
                                        <center>{{$data->tb_position->name}}</center>
                                    </td>
                                    <td>
                                        <center>{{$data->tb_departement->name}}</center>
                                    </td>
                                    <td>
                                        <center>Rp.{{$data->besaran_uang}}</center>
                                    </td>
                                    <td>
                                        <center>
                                            <div class="btn-group">
                                                <a href="{{ route('kategori_lembur.edit', $data->id) }}" class="btn btn-sm btn-warning app-shadow">
                                                    <i class="fas fa-edit fa-fw"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger app-shadow" onclick="hapus({{$data->id}})">
                                                    <i class="fas fa-trash fa-fw"></i>
                                                </button>
                                            </div>
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
@endsection
@section('scripts')
<script src="{{ asset ('js/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    function hapus(id) {
        swal({
                title: "Apakah Anda Yakin?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Tidak, Batalkan!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{ url('kategori_lembur') }}" + '/' + id,
                        type: "POST",
                        data: {
                            '_method': 'DELETE',
                            '_token': $('meta[name=csrf-token]').attr('content')
                        },
                        success: function(data) {
                            swal("Terhapus!", "Data berhasil dihapus.", "success");
                            $('#hide' + id).hide();
                        },
                        error: function() {
                            swal("Gagal!", "Data gagal dihapus.", "error");
                        }
                    });
                } else {
                    swal("Dibatalkan", "Data batal dihapus.", "error");
                }
            });
    }
</script>
@endsection