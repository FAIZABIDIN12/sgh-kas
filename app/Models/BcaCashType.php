<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcaCashType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'keterangan'
    ];

    public function bcaCashFlows()
    {
        return $this->hasMany(BcaCashflow::class);
    }
}
