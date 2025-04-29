<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profesor_id');
            $table->unsignedBigInteger('alumno_id');
            $table->string('nombre_profesor_practicas')->nullable();
            $table->string('empresa_practicas')->nullable();
            $table->string('monitor_empresa')->nullable();
            $table->string('grado_estudiante')->nullable();
            $table->string('curso_academico')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Claves foráneas
            $table->foreign('profesor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('alumno_id')->references('id')->on('users')->onDelete('cascade');
    
            // Asegurar que un alumno solo pertenece a un grupo
            $table->unique(['alumno_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
