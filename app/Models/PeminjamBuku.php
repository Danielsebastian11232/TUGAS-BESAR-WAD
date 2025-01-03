<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamBuku extends Model
{
    protected $table = 'peminjam_buku';
    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'returned'
    ];

    //casts (gunanya buat bisa menggunakan helper function seperti format tanggal dari laravel)
    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function buku()
    {
        return $this->belongsTo(KoleksiBuku::class, 'buku_id', 'id');
    }
}
