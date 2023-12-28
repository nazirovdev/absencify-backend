<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->text('password')->default(Hash::make('123'));
            $table->string('nama');
            $table->enum('jenis_kelamin', ['l', 'p']);
            $table->string('alamat');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('classroom_id');
            $table->timestamps();

            $table->foreign('classroom_id')->on('classrooms')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
};
