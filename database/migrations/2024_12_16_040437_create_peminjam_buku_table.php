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
        Schema::create('peminjam_buku', function (Blueprint $table) {
            $table->id();
            //foreign key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('koleksi_buku')->onDelete('cascade');
            $table->datetime('tanggal_pinjam')->nullable();
            $table->datetime('tanggal_kembali')->nullable();
            $table->boolean('returned')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjam_buku');
    }
};
