<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaDeClase extends Model
{
    use HasFactory;

    protected $table = 'notas_de_clase';

    protected $fillable = [
        'fecha',
        'hora_inicio',
        'hora_fin',
        'contenido',
        'tema',
        'observaciones',
        'usuario_id',
        'asignatura_id',
        'visible',
    ];
    protected $casts = [
        'visible' => 'boolean',
    ];
    
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class); //N a 1
    }

    public function usuario()
    {
        return $this->belongsTo(User::class); //N a 1
    }

    public function scopeVisible($query)
    {
        return $query->where('visible', true); 
    }
}
