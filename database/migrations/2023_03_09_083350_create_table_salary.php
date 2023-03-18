<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSalary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_salary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('staff_id');
            $table->double('salary')->default(0);
            $table->string('periode')->nullable();
            $table->integer('jumlah_jam_lembur');
            $table->integer('jumlah_jam_lembur_berdasarkan_periode');
            $table->integer('gaji_lembur_perjam');
            $table->integer('jumlah_uang_lembur');
            $table->integer('gaji_pokok');
            $table->double('total')->nullable()->default(0);
            $table->string('status_gaji')->nullable();
            $table->date('tgl_salary');
            $table->string('status')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('staff_id')->references('id')->on('tb_staff')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_salary');
    }
}
