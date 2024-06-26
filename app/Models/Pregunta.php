<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    // use HasFactory;
    protected $fillable = [
        'encuesta',
        'seccion',
        'asignacion',
        'momento',
        'pregunta',
        'tipo',
        'area',
        'nivel',
        'obligatorio',
        'orden',
        'subnivel',
        'name',
    ];
}
