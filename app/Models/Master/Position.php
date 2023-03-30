<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'tb_position';
    protected $fillable = ['name', 'salary_position', 'status'];

    public function getNameAttribute($name)
    {
        return strtoupper($name);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function kategori_lembur()
    {
        return $this->belongsTo(kategori_lembur::class);
    }
}
