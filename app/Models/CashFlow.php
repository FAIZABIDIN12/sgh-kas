<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'uraian', 'cash_type_id', 'nominal', 'user_id'
    ];

    public function cashType()
    {
        return $this->belongsTo(CashType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
