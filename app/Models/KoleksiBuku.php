<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoleksiBuku extends Model
{
    protected $table = 'koleksi_buku';
    protected $fillable = [
        'kode_buku',
        'kategori_id',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'jumlah_buku',
        'deskripsi',
        'cover',
        'stok_buku'
    ];

    //casts (gunanya buat bisa menggunakan helper function seperti format tanggal dari laravel)
    protected $casts = [
        'tahun_terbit' => 'date',

    ];

    public function kategori()
    {
        return $this->belongsTo(CategoryBook::class, 'kategori_id', 'id');
    }


}
