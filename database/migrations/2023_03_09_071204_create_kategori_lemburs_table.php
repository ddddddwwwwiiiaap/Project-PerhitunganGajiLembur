<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriLembursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_lemburs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_lembur')->unique();
            $table->integer('position_id')->unsigned();
            $table->foreign('position_id')->on('tb_position')->references('id')->onDelete('Cascade')->onUpdate('Cascade');
            $table->integer('departement_id')->unsigned();
            $table->foreign('departement_id')->on('tb_departement')->references('id')->onDelete('Cascade')->onUpdate('Cascade');
            $table->integer('besaran_uang');
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
        Schema::dropIfExists('kategori_lemburs');
    }
}
