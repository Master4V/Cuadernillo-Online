<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the practicas for the user.
     */
    public function practicas(): HasMany
    {
        return $this->hasMany(Practica::class);
    }

    /**
     * Check if the user is an alumno.
     */
    public function isAlumno(): bool
    {
        return $this->role === 'alumno';
    }

    /**
     * Check if the user is a profesor.
     */
    public function isProfesor(): bool
    {
        return $this->role === 'profesor';
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function grupoComoAlumno()
    {
        return $this->hasOne(Grupo::class, 'alumno_id');
    }

    public function alumnosComoProfesor()
    {
        return $this->hasMany(Grupo::class, 'profesor_id');
    }
}
