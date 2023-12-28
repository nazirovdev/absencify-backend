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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('titik_lokasi')->nullable();
            $table->integer('radius')->nullable();
            $table->string('smt_gasal_awal')->nullable();
            $table->string('smt_gasal_tengah')->nullable();
            $table->string('smt_gasal_akhir')->nullable();

            $table->string('smt_genap_awal')->nullable();
            $table->string('smt_genap_tengah')->nullable();
            $table->string('smt_genap_akhir')->nullable();

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
        Schema::dropIfExists('settings');
    }
};
