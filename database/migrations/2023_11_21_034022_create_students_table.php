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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->text('password');
            $table->string('nama');
            $table->string('alamat');
            $table->string('image')->nullable();
            $table->enum('jenis_kelamin', ['l', 'p']);
            $table->unsignedBigInteger('guardian_id');
            $table->unsignedBigInteger('classroom_id');
            $table->string('telepon');
            $table->string('token')->nullable();
            $table->timestamps();

            $table->foreign('guardian_id')->references('id')->on('guardians')->cascadeOnDelete();
            $table->foreign('classroom_id')->references('id')->on('classrooms')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
