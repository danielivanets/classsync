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
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            // Clave foránea al departamento
            $table->foreignId('departamento_id')->nullable()->constrained()->onDelete('set null'); 
            // Clave foránea al aula
            $table->foreignId('aula_id')->nullable()->constrained()->onDelete('set null'); //onDelete('cascade');
            // Profesor que imparte la asignatura (usuario)
            $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null'); //onDelete('cascade');
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaturas');
    }

    
};
