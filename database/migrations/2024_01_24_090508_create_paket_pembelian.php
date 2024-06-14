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
        Schema::create('paket_pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->integer('harga_paket');
            $table->string('gambar');
            $table->json('perlengkapan');
            $table->integer('diskon');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_pembelian');
    }
};
