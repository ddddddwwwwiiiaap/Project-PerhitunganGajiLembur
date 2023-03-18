<div class="card-body">
    <div class="card card-solid">
        <div class="card-body pb-0 pt-3">
            <blockquote>
                <b>Keterangan!!</b><br>
                <small><cite title="Source Title">Inputan Yang Ditanda Bintang Merah (<span class="text-danger">*</span>) Harus Di Isi !!</cite></small>
            </blockquote>
        </div>
    </div>
    <div class="card-header with-border pl-0 pb-1">
        <span class="col-form-label text-bold">Kategori Lembur</span>
    </div>
    <br>
    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Masukkan Kode Lembur <span class="text-danger">*</span></label>
        <div class="col-12 col-md-5 col-lg-5">
            <input type="text" name="kode_lembur" class="form-control @error('kode_lembur') is-invalid @enderror" value="{{ old('kode_lembur', $kategori_lembur->kode_lembur ?? '') }}">
            @error('kode_lembur')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('kode_lembur') }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Nama Position <span class="text-danger">*</span></label>
        <div class="col-12 col-md-5 col-lg-5">
            <select name="position_id" class="form-control @error('position_id') is-invalid @enderror">
                <option value="">-- Pilih Position --</option>
                @foreach ($position as $item)
                <option value="{{ $item->id }}" {{ $item->id == old('position_id', $kategori_lembur->position_id ?? '') ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
            @error('position_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('position_id') }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Nama Departement <span class="text-danger">*</span></label>
        <div class="col-12 col-md-5 col-lg-5">
            <select name="departement_id" class="form-control @error('departement_id') is-invalid @enderror">
                <option value="">-- Pilih Departement --</option>
                @foreach ($departement as $item)
                <option value="{{ $item->id }}" {{ $item->id == old('departement_id', $kategori_lembur->departement_id ?? '') ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
            @error('departement_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('departement_id') }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Besaran Uang</label>
        <div class="col-12 col-md-5 col-lg-5">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input type="text" name="besaran_uang" class="form-control @error('besaran_uang') is-invalid @enderror" value="{{ old('besaran_uang', $kategori_lembur->besaran_uang ?? '') }}" placeholder="100.000" autocomplete="off" oninput="format(this)">
            </div>
            @error('besaran_uang')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('besaran_uang') }}</strong>
                </span>
            @enderror
        </div> 
    </div> 

</div>
<div class="card-footer">
    <div class="offset-md-4">
        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary mr-1"><i class="fas fa-check-double mr-1"></i> Simpan</button>
            <button type="reset" class="btn btn-secondary"><i class="fas fa-undo mr-1"></i> Reset</button>
        </div>
    </div>
</div>