@extends('adminlte::page')

@section('title', 'Editar Aula')

@section('content_header')
    <h1 class="mb-3">Editar Aula: <strong>{{ $aula->nombre }}</strong></h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-door-open mr-1"></i> Datos del Aula
                </h3>
            </div>

            {!! Form::model($aula, ['route' => ['aulas.update', $aula->id], 'method' => 'put']) !!}
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre">Nombre del Aula</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $aula->nombre) }}" required>
                </div>

                <div class="form-group">
                    <label for="capacidad">Capacidad</label>
                    <input type="number" name="capacidad" id="capacidad" class="form-control" value="{{ old('capacidad', $aula->capacidad) }}" required>
                </div>

                <div class="form-group">
                    <label for="tipo">Tipo de Aula</label>
                    <select name="tipo" id="tipo" class="form-control" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="Aula" {{ old('tipo', $aula->tipo) == 'Aula' ? 'selected' : '' }}>Aula</option>
                        <option value="Laboratorio" {{ old('tipo', $aula->tipo) == 'Laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                        <option value="Auditorio" {{ old('tipo', $aula->tipo) == 'Auditorio' ? 'selected' : '' }}>Auditorio</option>
                        <option value="Taller" {{ old('tipo', $aula->tipo) == 'Taller' ? 'selected' : '' }}>Taller</option>
                        <option value="Virtual" {{ old('tipo', $aula->tipo) == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                        <option value="Musica" {{ old('tipo', $aula->tipo) == 'Musica' ? 'selected' : '' }}>Música</option>
                        <option value="Idiomas" {{ old('tipo', $aula->tipo) == 'Idiomas' ? 'selected' : '' }}>Idiomas</option>
                        <option value="Reuniones" {{ old('tipo', $aula->tipo) == 'Reuniones' ? 'selected' : '' }}>Reuniones</option>
                    </select>
                </div>
                

                <div class="form-group">
                    <label for="ubicacion">Ubicación</label>
                    <select name="ubicacion" id="ubicacion" class="form-control" required>
                        <option value="">Seleccione una ubicación</option>
                        <option value="Planta 0" {{ old('ubicacion', $aula->ubicacion) == 'Planta 0' ? 'selected' : '' }}>Planta 0</option>
                        <option value="Planta 1" {{ old('ubicacion', $aula->ubicacion) == 'Planta 1' ? 'selected' : '' }}>Planta 1</option>
                        <option value="Planta 2" {{ old('ubicacion', $aula->ubicacion) == 'Planta 2' ? 'selected' : '' }}>Planta 2</option>
                        <option value="Planta 3" {{ old('ubicacion', $aula->ubicacion) == 'Planta 3' ? 'selected' : '' }}>Planta 3</option>
                        <option value="Patio" {{ old('ubicacion', $aula->ubicacion) == 'Patio' ? 'selected' : '' }}>Patio</option>
                    </select>
                </div>

            </div>

            <div class="card-footer text-right">
                <a href="{{ route('aulas.index') }}" class="btn btn-secondary mr-2">
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
