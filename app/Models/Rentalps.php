<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rentalps extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'no',
        'nama',
        'jenis',
        'date',
    ];
}
