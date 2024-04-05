<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pagina_cerrada extends Model
{
    // use HasFactory;
    protected $fillable = [
        'encuesta',
        'cerrada',
    ];
}
