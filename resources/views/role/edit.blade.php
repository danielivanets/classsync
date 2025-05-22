@extends('adminlte::page')

@section('title', 'Editar Rol')

@section('content_header')
    <h1 class="mb-3">Editar Rol: <strong>{{ $role->name }}</strong> <small class="text-muted">(ID: {{ $role->id }})</small></h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos del Rol</h3>
            </div>

            {!! Form::model($role, ['route'=> ['role.update', $role->id], 'method' => 'put']) !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="text" class="form-control" id="id" value="{{ $role->id }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="name">Nombre del Rol *</label>
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre del rol', 'required']) !!}
                    </div>

                    <hr>
                    <h5 class="mb-3"><i class="fas fa-key mr-1"></i> Permisos Asignados</h5>

                    <div class="row">
                        @foreach($permission as $permis)
                            <div class="col-md-6 mb-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" 
                                           name="permissions[]" 
                                           id="customCheckbox{{ $permis->id }}" 
                                           value="{{ $permis->name }}"
                                           {{ in_array($permis->id, $permisos_rol) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customCheckbox{{ $permis->id }}">
                                        {{ ucfirst(str_replace('_', ' ', $permis->name)) }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('role.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .card-title {
            font-size: 1.25rem;
        }

        .custom-control-label {
            font-weight: 500;
        }

        .form-group label {
            font-weight: bold;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Formulario de edición de roles cargado correctamente.");
    </script>
@stop
