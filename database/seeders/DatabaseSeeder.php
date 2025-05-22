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
        //Profesores:

        $profesor1 = User::create([
            'name' => 'Docarmo',
            'email' => 'docarmo@example.com',
            'password' => Hash::make('1234'),
            'role' => 'profesor',
        ]);
        $profesor2 = User::create([
            'name' => 'Felix',
            'email' => 'felix@example.com',
            'password' => Hash::make('1234'),
            'role' => 'profesor',
        ]);
        $profesor3 = User::create([
            'name' => 'Gonzalo',
            'email' => 'gonzalo@example.com',
            'password' => Hash::make('1234'),
            'role' => 'profesor',
        ]);
        $profesor4 = User::create([
            'name' => 'Arancha',
            'email' => 'arancha@example.com',
            'password' => Hash::make('1234'),
            'role' => 'profesor',
        ]);
        $profesor5 = User::create([
            'name' => 'Rosa',
            'email' => 'rosa@example.com',
            'password' => Hash::make('1234'),
            'role' => 'profesor',
        ]);

        //Alumnos:
        $alumno1 = User::create([
            'name' => 'Jesus BR',
            'email' => 'jesusbr@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno2 = User::create([
            'name' => 'Alvaro BD',
            'email' => 'alvarobd@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno3 = User::create([
            'name' => 'MJ CA',
            'email' => 'mjca@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno4 = User::create([
            'name' => 'Javier DB',
            'email' => 'javierdb@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno5 = User::create([
            'name' => 'Victor DG',
            'email' => 'victordg@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno6 = User::create([
            'name' => 'Alvaro EE',
            'email' => 'alvaroee@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno7 = User::create([
            'name' => 'Victor MM',
            'email' => 'victormm@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno8 = User::create([
            'name' => 'MA MP',
            'email' => 'mamp@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno9 = User::create([
            'name' => 'Irene PR',
            'email' => 'irenepr@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno10 = User::create([
            'name' => 'Marcos RO',
            'email' => 'marcosro@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno11 = User::create([
            'name' => 'Antonio RD',
            'email' => 'antoniord@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno12 = User::create([
            'name' => 'Jade RP',
            'email' => 'jaderp@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno13 = User::create([
            'name' => 'Dario SR',
            'email' => 'dariosr@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno14 = User::create([
            'name' => 'Antonio SR',
            'email' => 'antoniosr@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        $alumno15 = User::create([
            'name' => 'MJ VC',
            'email' => 'mjvc@example.com',
            'password' => Hash::make('1234'),
            'role' => 'alumno',
        ]);
        /*
        //Grupos:
        Grupo::create([
            'profesor_id' => $profesor1->id,
            'alumno_id' => $alumno1->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor1->id,
            'alumno_id' => $alumno2->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor5->id,
            'alumno_id' => $alumno3->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor1->id,
            'alumno_id' => $alumno4->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor1->id,
            'alumno_id' => $alumno5->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor4->id,
            'alumno_id' => $alumno6->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor1->id,
            'alumno_id' => $alumno7->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor2->id,
            'alumno_id' => $alumno8->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor3->id,
            'alumno_id' => $alumno9->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor4->id,
            'alumno_id' => $alumno10->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor5->id,
            'alumno_id' => $alumno11->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor2->id,
            'alumno_id' => $alumno12->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor2->id,
            'alumno_id' => $alumno13->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor2->id,
            'alumno_id' => $alumno14->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);
        Grupo::create([
            'profesor_id' => $profesor3->id,
            'alumno_id' => $alumno15->id,
            'curso_academico' => '2025/2026',
            'familia_profesional' => 'Informática y Comunicaciones',
            'ciclo' => 'Desarrollo de Aplicaciones Multiplataforma',
            'grado' => 'Grado Superior',
        ]);*/
    }
}


/* Seed de prueba doomie
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
 */