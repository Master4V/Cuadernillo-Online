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
        'empresa_id',
        'centro_docente',
        'nombre_profesor_practicas',
        'empresa_practicas',
        'tutor_empresa',
        'periodo_realizacion',
        'curso_academico',
        'familia_profesional',
        'ciclo',
        'grado'
    ];

    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    public function alumno()
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id');
    }
}