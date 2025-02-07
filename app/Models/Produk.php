<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'kode_produk';
    public $incrementing = false;

    protected $fillable = ['kode_produk', 'nama_produk'];
}
