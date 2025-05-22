<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia',
        'hora_inicio',
        'hora_fin',
        'asignatura_id',
        'aula_id',
        'visible',
    ];
    protected $casts = [
        'visible' => 'boolean',
    ];
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class); //N a 1
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class); //N a 1
    }
}
