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
        <span class="col-form-label text-bold">STAFF</span>
    </div>
    <br> 
    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Nama <span class="text-danger">*</span></label> 
        <div class="col-12 col-md-5 col-lg-5">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $staff->name ?? '') }}" placeholder="Nama lengkap.." autocomplete="off">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @enderror
        </div> 
    </div>

    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">NIP <span class="text-danger">*</span></label> 
        <div class="col-12 col-md-5 col-lg-5">
            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $staff->nip ?? '') }}" placeholder="NIP.." autocomplete="off">
            @error('nip')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nip') }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Tgl. lahir <span class="text-danger">*</span></label> 
        <div class="col-12 col-md-5 col-lg-5">
            <input type="date" name="birth" class="form-control @error('birth') is-invalid @enderror" value="{{ old('birth', $staff->birth ?? '') }}" autocomplete="off">
            @error('birth')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('birth') }}</strong>
                </span>
            @enderror
        </div> 
    </div>

    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Tgl. Mulai Kerja <span class="text-danger">*</span></label> 
        <div class="col-12 col-md-5 col-lg-5">
            <input type="date" name="startdate" class="form-control @error('startdate') is-invalid @enderror" value="{{ old('startdate', $staff->startdate ?? '') }}" autocomplete="off">
            @error('startdate')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('startdate') }}</strong>
                </span>
            @enderror
        </div> 
    </div>

    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">No. Telp <span class="text-danger">*</span></label> 
        <div class="col-12 col-md-5 col-lg-5">
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $staff->phone ?? '') }}" placeholder="0823..." onkeypress="return hanyaAngka(this)">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @enderror
        </div> 
    </div>

    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Upah Pokok</label>
        <div class="col-12 col-md-5 col-lg-5">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input type="text" name="salary_staff" class="form-control @error('salary_staff') is-invalid @enderror" value="{{ old('salary_staff', $staff->salary_staff ?? '') }}" placeholder="100.000" autocomplete="off" oninput="format(this)">
                @error('salary_staff')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('salary_staff') }}</strong>
                    </span>
                @enderror
            </div>
        </div> 
    </div> 

    <div class="form-group row">
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Premium <span class="text-danger">*</span></label> 
        <div class="col-12 col-md-5 col-lg-5">
            <select name="position_id" class="form-control select2 @error('position_id') is-invalid @enderror">
                <option value=""></option>
                @foreach ($position as $item)
                    <option value="{{ $item->id }}" {{ $item->id == old('position_id', $staff->position_id ?? '') ? 'selected' : '' }}>{{ $item->name }}</option>
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
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Job Grade <span class="text-danger">*</span></label> 
        <div class="col-12 col-md-5 col-lg-5">
            <select name="departement_id" class="form-control select2 @error('departement_id') is-invalid @enderror">
                <option value=""></option>
                @foreach ($departement as $item)
                    <option value="{{ $item->id }}" {{ $item->id == old('departement_id', $staff->departement_id ?? '') ? 'selected' : '' }}>{{ $item->name }}</option>
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
        <label class="col-md-4 col-xs-4 col-form-label justify-flex-end">Alamat <span class="text-danger">*</span></label> 
        <div class="col-12 col-md-5 col-lg-5">
            <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Masukan alamat..">{{ old('address', $staff->address ?? '') }}</textarea>
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('address') }}</strong>
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