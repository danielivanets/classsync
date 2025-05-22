@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1 class="mb-3">Perfil de Usuario</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <i class="fas fa-user-circle fa-2x mr-2"></i>
                <h3 class="card-title mb-0">Información del Perfil</h3>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <h5><i class="fas fa-user mr-2 text-primary"></i> <strong>Nombre:</strong></h5>
                    <p class="ml-4">{{ $user->name }}</p>
                </div>

                <div class="mb-3">
                    <h5><i class="fas fa-envelope mr-2 text-primary"></i> <strong>Correo Electrónico:</strong></h5>
                    <p class="ml-4">{{ $user->email }}</p>
                </div>


                <div class="text-right mt-4">
                    <a href="{{ route('profile.edit', $user) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit mr-1"></i> Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
