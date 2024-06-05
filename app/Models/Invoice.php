<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tamu',
        'tgl_checkin',
        'tgl_checkout',
        'pax',
        'tagihan',
        'sp',
        'fo',
    ];
}
