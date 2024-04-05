<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class configuracion_encuesta extends Model
{
     // use HasFactory;
     protected $fillable = [
        'hash',
        'encuesta',
        'publicada',
        'programada_inicio',
        'programada_fin',
        'fecha_inicio',
        'fecha_fin',

    ];
}
