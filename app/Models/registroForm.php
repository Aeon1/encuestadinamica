<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registroForm extends Model
{
    // use HasFactory;
    protected $fillable = [
        'encuesta',
        'tipo',
        'obligatorio',
    ];
}
