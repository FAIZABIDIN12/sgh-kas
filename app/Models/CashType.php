<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis'
    ];

    public function cashFlows()
    {
        return $this->hasMany(CashFlow::class);
    }
}
