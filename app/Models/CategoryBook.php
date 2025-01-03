<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryBook extends Model
{
    protected $table = 'kategori_buku';
    protected $fillable = ['nama_kategori'];
    public $timestamps = false;
}
