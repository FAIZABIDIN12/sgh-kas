<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'uraian', 'cash_type_id', 'masuk', 'keluar', 'saldo', 'fo',
    ];

    public function cashType()
    {
        return $this->belongsTo(CashType::class);
    }
}
