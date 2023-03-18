<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembur_Pegawai extends Model
{
    protected $table = 'tb_lembur_pegawai';
    protected $fillable = ['kategori_lembur_id', 'staff_id', 'periode', 'mulai_lembur', 'selesai_lembur', 'jumlah_jam', 'total_uang_lembur', 'tanggal_lembur'];
    protected $dates = ['deleted_at'];

    public function kategori_lembur()
    {
        return $this->belongsTo('App\Models\Kategori_Lembur', 'kategori_lembur_id');
    }

    public function staff()
    {
        return $this->belongsTo('App\Models\Master\Staff', 'staff_id');
    }
}
    