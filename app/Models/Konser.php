<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konser extends Model
{
    protected $table = 'konser';

    protected $fillable = [
        'nama_konser', 
        'artis', 
        'tanggal', '
        lokasi', 
        'harga_tiket', 
        'kuota',
    ];
}