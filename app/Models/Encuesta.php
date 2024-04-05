<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    // use HasFactory;
    protected $fillable = [
        'contexto',
        'nombre',
        'institucional',
        'estatus',
    ];
}
