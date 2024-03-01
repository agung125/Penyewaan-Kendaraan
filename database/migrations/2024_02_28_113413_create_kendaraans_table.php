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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->unsignedBigInteger('supir_id')->nullable();
            $table->string('image');
            $table->string('nama_kendaraan');
            $table->string('jenis_kendaraan');
            $table->bigInteger('konsumsi_bbm')->nullable();
            $table->date('riwayat_pemaikaian')->nullable();
            $table->date('jadwal_service');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('kendaraans');
    }
};
