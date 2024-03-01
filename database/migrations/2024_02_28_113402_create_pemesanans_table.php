<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pemesanans', function (Blueprint $table) {
         $table->id();

         $table->bigInteger('supir_id')->unsigned();
         $table->unsignedBigInteger('kendaraan_id')->nullable();
         $table->bigInteger('pengelola_id')->unsigned();
         $table->bigInteger('uang_bbm');
         $table->string('lokasi_tujuan');
         $table->date('tanggal_berangkat');
         $table->enum('status', ['pending', 'disetujui', 'tidak disetujui'])->default('pending');
         $table->unsignedBigInteger('user_approve_1_id')->nullable();
         $table->unsignedBigInteger('user_approve_2_id')->nullable();
         $table->foreign('user_approve_1_id')->references('id')->on('users')->onDelete('set null');
         $table->foreign('user_approve_2_id')->references('id')->on('users')->onDelete('set null');


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
        Schema::dropIfExists('pemesanans');
    }
};
