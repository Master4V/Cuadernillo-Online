<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'mail',
        'tutor'
    ];

    public static $rules = [
        'nombre' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'telefono' => 'required|string|max:20',
        'tutor' => 'required|string|max:255',
        'mail' => 'nullable|email'
    ];

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'empresa_id');
    }
}
