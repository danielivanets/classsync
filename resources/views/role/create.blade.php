@extends('adminlte::page')

@section('title', 'Nuevo Rol')

@section('content_header')
    <h1 class="mb-3">Crear Nuevo Rol</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-tag mr-2"></i>Datos del Rol</h3>
            </div>

            {!! Form::open(['route' => ['role.store'], 'method' => 'POST']) !!}
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre"><strong>Nombre del Rol *</strong></label>
                    <input type="text" class="form-control" id="nombre" name="name" placeholder="Ej: Administrador" required>
                    <small class="form-text text-muted">Este nombre debe ser único y representativo.</small>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Rol
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
            font-size: 1.2rem;
        }

        .form-text {
            font-size: 0.85rem;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Formulario de creación de rol cargado.");
    </script>
@stop
