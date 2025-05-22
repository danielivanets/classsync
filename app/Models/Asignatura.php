<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'usuario_id',
        'aula_id',
        'departamento_id',
        'visible',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'usuario_id'); //N a 1
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class); //N a 1
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class); //N a 1
    }

    public function notas()
    {
        return $this->hasMany(NotaDeClase::class); //1 a N
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class); //1 a N
    }
}