<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori_Lembur extends Model
{
    protected $table = 'tb_kategori_lembur';
    protected $fillable = ['kode_lembur','position_id','departement_id','besaran_uang'];
    protected $dates = ['deleted_at'];
    public $timestamps = true;

    public function tb_position()
    {
        return $this->belongsTo('App\Models\Master\Position','position_id');
    }

    public function tb_departement()
    {
        return $this->belongsTo('App\Models\Master\Departement','departement_id');
    }

    public function lembur_pegawai()
    {
        return $this->hasMany('App\Models\Master\Lembur_Pegawai','kategori_lembur_id');
    }
}
