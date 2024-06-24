<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BcaCashflow extends Model
{
    protected $fillable = ['tanggal', 'uraian', 'nominal', 'type'];
}
