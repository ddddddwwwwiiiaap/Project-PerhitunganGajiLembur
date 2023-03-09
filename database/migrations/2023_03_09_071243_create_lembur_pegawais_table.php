<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLemburPegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lembur_pegawais', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kategori_lembur_id')->unsigned();
            $table->foreign('kategori_lembur_id')->on('kategori_lemburs')->references('id')->onDelete('Cascade')->onUpdate('Cascade');
            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->on('tb_staff')->references('id')->onDelete('Cascade')->onUpdate('Cascade');
            $table->time('mulai_lembur');
            $table->time('selesai_lembur');
            $table->integer('jumlah_jam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lembur_pegawais');
    }
}
