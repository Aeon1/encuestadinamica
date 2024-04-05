<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroFormTemplate extends Model
{
    // use HasFactory;
    protected $fillable = [
        'texto',
        'campo',
        'name',
        'activo',
    ];
}
