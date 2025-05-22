<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected static function booted()
    {
        //static::created(function ($user) {
        //    if (!$user->hasAnyRole()) {
        //        $user->assignRole('Invitado');
        //    }
        //});
    }

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Los atributos que deben estar ocultos al serializar.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Devuelve la imagen del perfil.
     */
    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    /**
     * Devuelve la descripción del perfil (rol).
     */
    public function adminlte_desc()
    {
        // Muestra el primer rol del usuario si tiene alguno
        return $this->getRoleNames()->first() ?? 'Sin rol';
    }

    /**
     * Devuelve la URL del perfil.
     */
    public function adminlte_profile_url()
    {
        return route('profile.show', $this->id);
    }
    
    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class, 'usuario_id');
    }
    
    public function notasDeClase()
    {
        return $this->hasMany(NotaDeClase::class);
    }
    
}
