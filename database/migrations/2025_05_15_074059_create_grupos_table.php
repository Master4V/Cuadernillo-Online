<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profesor_id');
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->string('centro_docente')->nullable();
            $table->string('nombre_profesor_practicas')->nullable();
            $table->string('empresa_practicas')->nullable();
            $table->string('tutor_empresa')->nullable();
            $table->string('periodo_realizacion')->nullable();
            $table->string('curso_academico')->nullable();
            $table->string('familia_profesional')->nullable();
            $table->string('ciclo')->nullable();
            $table->string('grado')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('profesor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('alumno_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};