@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1 class="mb-3">Editar Usuario: <strong>{{ $user->name }}</strong></h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Datos del Usuario</h3>
            </div>
            {!! Form::model($user, ['route' => ['admin.update', $user->id], 'method' => 'put']) !!}
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="name" id="nombre" class="form-control" value="{{ $user->name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Nueva Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Dejar en blanco para mantener la actual">
                </div>

                <div class="form-group">
                    <label>Roles asignados</label>
                    <div class="row">
                        @foreach($roles as $rol)
                        <div class="col-sm-6">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="customCheckbox{{ $rol->id }}" name="roles[]" value="{{ $rol->name }}"
                                {{ in_array($rol->id, $roles_usuario) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheckbox{{ $rol->id }}">{{ $rol->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('admin.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save mr-1"></i> Guardar Cambios
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
