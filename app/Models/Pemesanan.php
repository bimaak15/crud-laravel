<?php

namespace App\Models;
use App\Models\Konser;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id', 
        'konser_id', 
        'jumlah_tiket', 
        'status',
    ];

    public function konser()
    {
        return $this->belongsTo(Konser::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}