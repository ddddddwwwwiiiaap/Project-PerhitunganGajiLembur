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
                    <a href="{{ route('lembur_pegawai.create') }}" class="btn btn-default app-shadow d-none d-md-inline-block ml-auto">
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
                            Data Jadwal Staf
                            <span id="count" class="badge badge-danger float-right float-xl-right mt-1">{{ $count }}</span>
                        </div>
                        <table id="datatable" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 100px;">#</th>
                                    <th>
                                        <center>Kode Kategori Lembur</center>
                                    </th>
                                    <th>
                                        <center>NIP</center>
                                    </th>
                                    <th>
                                        <center>Nama staff</center>
                                    </th>
                                    <th>
                                        <center>Mulai Lembur</center>
                                    </th>
                                    <th>
                                        <center>Selesai Lembur</center>
                                    </th>
                                    <th>
                                        <center>Jumlah Jam</center>
                                    </th>
                                    <th>
                                        <center>Besaran Uang</center>
                                    </th>
                                    <th>
                                        <center>Total</center>
                                    </th>
                                    <th>
                                        <center>Tanggal Buat</center>
                                    </th>
                                    <th>
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($lembur_pegawai as $data)
                                <tr id="hide{{$data->id}}">
                                    <td>
                                        <center>{{$no++}}</center>
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
                                        <center>{{$data->Kategori_lembur->besaran_uang}}</center>
                                    </td>
                                    <td>
                                        <center>{{$data->jumlah_jam * $data->Kategori_lembur->besaran_uang}}</center>
                                    </td>
                                    <td>
                                        <center>{{$data->created_at}}</center>
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
                        url: "{{URL::to('//destroy')}}",
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