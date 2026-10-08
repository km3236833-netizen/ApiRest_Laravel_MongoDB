<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Libro extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'libros';

    protected $fillable = [
        'titulo',
        'autor',
        'editorial',
        'anio',
    ];
}