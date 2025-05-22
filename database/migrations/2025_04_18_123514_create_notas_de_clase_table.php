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
        Schema::create('notas_de_clase', function (Blueprint $table) {
            $table->id();
            $table->date('fecha'); // día de la clase
            $table->time('hora_inicio')->nullable(); // si un profesor tiene varias franjas
            $table->time('hora_fin')->nullable();
            $table->text('contenido');
            $table->string('tema')->nullable(); // título/resumen del tema de la clase
            $table->string('observaciones')->nullable(); // para comentarios extra
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade'); // profesor
            $table->foreignId('asignatura_id')->constrained()->onDelete('cascade');
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_de_clase');
    }
};
