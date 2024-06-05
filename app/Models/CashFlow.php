<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'uraian', 'jenis', 'masuk', 'keluar', 'saldo', 'fo',
    ];
}
