@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h4 class="mb-3"><i class="fas fa-user-plus text-primary"></i> Nuevo Usuario</h4>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-id-card-alt"></i> Datos del Usuario</h5>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
            {!! Form::open(['route' => ['admin.store'], 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre"><i class="fas fa-user mr-1 text-muted"></i> Nombre completo</label>
                        <input type="text" class="form-control" id="nombre" name="name" placeholder="Ej. Juan Pérez" required>
                    </div>

                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope mr-1 text-muted"></i> Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ej. correo@ejemplo.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock mr-1 text-muted"></i> Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation"><i class="fas fa-lock mr-1 text-muted"></i> Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Repite la contraseña" required>
                    </div>
                    
                    <hr>
                    <label class="font-weight-bold">Asignar Roles</label>
                    
                    @foreach($roles as $rol)
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" value="{{ $rol->name }}" type="checkbox" name="roles[]" id="customCheckbox{{ $rol->id }}">
                            <label for="customCheckbox{{ $rol->id }}" class="custom-control-label">{{ $rol->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Guardar Usuario
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
