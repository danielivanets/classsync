<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'capacidad',
        'tipo',
        'ubicacion',
        'disponible',
        'visible',
    ];
    
    protected $casts = [
        'visible' => 'boolean',
    ];
    
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
