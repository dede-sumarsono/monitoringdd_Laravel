<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts3', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pembuat');
            $table->unsignedBigInteger('id_untuk_user');
            $table->string('username_untuk_user');
            $table->string('jenis_layanan');
            $table->string('jenis_pesanan');
            $table->text('keterangan');
            $table->string('status', 50);
            $table->string('dokumen')->nullable();
            $table->timestamps();

            $table->foreign('id_pembuat')->references('id')->on('users');
            $table->foreign('id_untuk_user')->references('id')->on('users');
            $table->foreign('username_untuk_user')->references('username')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts3');
    }
};
