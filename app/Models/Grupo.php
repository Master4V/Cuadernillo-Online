<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'profesor_id',
        'alumno_id',
        'nombre_profesor_practicas',
        'empresa_practicas',
        'monitor_empresa',
        'grado_estudiante',
        'curso_academico'
    ];

    // Relación con el profesor
    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    // Relación con el alumno
    public function alumno()
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }
}
