<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Grupo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 2 profesores
        $profesor1 = User::create([
            'name' => 'Profesor Uno',
            'email' => 'profesor1@example.com',
            'password' => Hash::make('password'),
            'role' => 'profesor',
        ]);

        $profesor2 = User::create([
            'name' => 'Profesor Dos',
            'email' => 'profesor2@example.com',
            'password' => Hash::make('password'),
            'role' => 'profesor',
        ]);

        // Crear 10 alumnos
        $alumnos = [];
        for ($i = 1; $i <= 10; $i++) {
            $alumnos[] = User::create([
                'name' => 'Alumno ' . $i,
                'email' => 'alumno' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'alumno',
            ]);
        }

        // Asignar 5 alumnos al primer profesor
        foreach (array_slice($alumnos, 0, 5) as $alumno) {
            Grupo::create([
                'profesor_id' => $profesor1->id,
                'alumno_id' => $alumno->id,
                'curso_academico' => '2025/2026',
                'familia_profesional' => 'Familia Profesional ' . rand(1, 5),
                'ciclo' => 'Ciclo ' . rand(1, 5),
                'grado' => 'Grado ' . rand(1, 2),
            ]);
        }

        // Asignar 5 alumnos al segundo profesor
        foreach (array_slice($alumnos, 5, 5) as $alumno) {
            Grupo::create([
                'profesor_id' => $profesor2->id,
                'alumno_id' => $alumno->id,
                'curso_academico' => '2025/2026',
                'familia_profesional' => 'Familia Profesional ' . rand(1, 5),
                'ciclo' => 'Ciclo ' . rand(1, 5),
                'grado' => 'Grado ' . rand(1, 2),
            ]);
        }
    }
}
