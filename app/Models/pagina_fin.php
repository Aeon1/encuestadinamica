<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pagina_fin extends Model
{
    // use HasFactory;
    protected $fillable = [
        'encuesta',
        'fin',
    ];
}
