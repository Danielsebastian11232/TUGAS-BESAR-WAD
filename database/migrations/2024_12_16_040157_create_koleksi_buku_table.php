<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('koleksi_buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku')->unique();
            $table->integer('kategori_id');
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->date('tahun_terbit');
            $table->integer('stok_buku');
            $table->text('deskripsi');
            $table->string('cover')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koleksi_buku');
    }
};
