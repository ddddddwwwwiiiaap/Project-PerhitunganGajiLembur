<?php

namespace App\Models;

use App\Models\Master\Staff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use SoftDeletes;

    protected $table = 'tb_salary';
    protected $fillable = ['staff_id', 'salary', 'periode', 'jumlah_jam_lembur', 'jumlah_jam_lembur_periode', 'gaji_lembur_perjam', 'jumlah_uang_lembur', 'gaji_pokok', 'total', 'status_gaji', 'tgl_salary', 'status'];
    protected $dates = ['deleted_at'];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
