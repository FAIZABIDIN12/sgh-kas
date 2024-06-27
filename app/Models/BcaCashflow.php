<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BcaCashflow extends Model
{
    protected $fillable = ['tanggal', 'uraian', 'nominal', 'bca_cash_type_id', 'user_id'];

    public function bcaCashType()
    {
        return $this->belongsTo(BcaCashType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
