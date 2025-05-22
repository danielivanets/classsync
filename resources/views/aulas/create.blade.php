@extends('adminlte::page')

@section('title', 'Crear Aula')

@section('content_header')
    <h4 class="mb-3"><i class="fas fa-chalkboard-teacher text-primary"></i> Nueva Aula</h4>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow rounded">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-door-open"></i> Datos del Aula</h5>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger m-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('aulas.store') }}" method="POST" autocomplete="off" class="m-3">
                @csrf

                <div class="form-group">
                    <label for="nombre"><i class="fas fa-chalkboard mr-1 text-muted"></i> Nombre del Aula *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required placeholder="Ej. Aula 101">
                </div>

                <div class="form-group">
                    <label for="capacidad"><i class="fas fa-users mr-1 text-muted"></i> Capacidad *</label>
                    <input type="number" name="capacidad" id="capacidad" class="form-control" value="{{ old('capacidad') }}" required min="1" placeholder="Ej. 30">
                </div>

                <div class="form-group">
                    <label for="tipo"><i class="fas fa-layer-group mr-1 text-muted"></i> Tipo de Aula *</label>
                    <select name="tipo" id="tipo" class="form-control" required>
                        <option value="" disabled {{ old('tipo', $aula->tipo ?? '') == '' ? 'selected' : '' }}>Seleccione un tipo</option>
                        <option value="Aula" {{ old('tipo', $aula->tipo ?? '') == 'Aula' ? 'selected' : '' }}>Aula</option>
                        <option value="Laboratorio" {{ old('tipo', $aula->tipo ?? '') == 'Laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                        <option value="Auditorio" {{ old('tipo', $aula->tipo ?? '') == 'Auditorio' ? 'selected' : '' }}>Auditorio</option>
                        <option value="Taller" {{ old('tipo', $aula->tipo ?? '') == 'Taller' ? 'selected' : '' }}>Taller</option>
                        <option value="Virtual" {{ old('tipo', $aula->tipo ?? '') == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                        <option value="Musica" {{ old('tipo', $aula->tipo ?? '') == 'Musica' ? 'selected' : '' }}>Música</option>
                        <option value="Idiomas" {{ old('tipo', $aula->tipo ?? '') == 'Idiomas' ? 'selected' : '' }}>Idiomas</option>
                        <option value="Reuniones" {{ old('tipo', $aula->tipo ?? '') == 'Reuniones' ? 'selected' : '' }}>Reuniones</option>
                    </select>
                </div>
                

                <div class="form-group">
                    <label for="ubicacion"><i class="fas fa-map-marker-alt mr-1 text-muted"></i> Ubicación *</label>
                    <select name="ubicacion" id="ubicacion" class="form-control" required>
                        <option value="" disabled {{ old('ubicacion') ? '' : 'selected' }}>Seleccione ubicación</option>
                        <option value="Planta 0" {{ old('ubicacion') == 'Planta 0' ? 'selected' : '' }}>Planta 0</option>
                        <option value="Planta 1" {{ old('ubicacion') == 'Planta 1' ? 'selected' : '' }}>Planta 1</option>
                        <option value="Planta 2" {{ old('ubicacion') == 'Planta 2' ? 'selected' : '' }}>Planta 2</option>
                        <option value="Planta 3" {{ old('ubicacion') == 'Planta 3' ? 'selected' : '' }}>Planta 3</option>
                        <option value="Patio" {{ old('ubicacion') == 'Patio' ? 'selected' : '' }}>Patio</option>
                    </select>
                </div>

                <div class="card-footer text-right p-0 mt-4">
                    <a href="{{ route('aulas.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Guardar Aula
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
