<div class="card-body pt-0 pl-1 pr-1 pb-0">

    @if (empty($staff))
    <div class="alert alert-warning text-justify">
        <strong>Warning !!</strong> Data staff belum ada, anda tidak dapat melakukan absensi. Silahkan input data staff terlebih dulu
        <a class="float-right" href="{{ route('salary.index') }}" data-toggle="tooltip" title="Silahkan klik untuk menginput data pekerja" style="text-decoration-color: blue;">
            <span class="text-primary">Input Sekarang ?</span>
        </a>
    </div>
    @endif

    

</div>
<div class="card-footer">
    <!--edit status_gaji-->
    @if ($salary->status_gaji == 'Belum Dibayar')
    <div class="form-group row">
        <label for="status_gaji" class="col-sm-2 col-form-label">Status Gaji</label>
        <div class="col-sm-10">
            <select name="status_gaji" id="status_gaji" class="form-control select2">
                <option value="Belum Dibayar" selected>Belum Dibayar</option>
                <option value="Sudah Dibayar">Sudah Dibayar</option>
            </select>
        </div>
    </div>
    @else
    @endif
    <div class="text-right">
        <div class="form-group mb-0">
            <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
            <button type="submit" class="btn btn-primary" name="submit"><i class="fas fa-check mr-1"></i> Simpan</button>
        </div>
    </div>
</div>