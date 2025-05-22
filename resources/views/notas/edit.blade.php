@extends('adminlte::page')

@section('title', 'Editar Nota de Clase')

@section('content_header')
    <h1 class="text-primary">Editar Nota de Clase</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5><i class="fas fa-edit"></i> Modificar los datos de la nota</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('notas.update', $nota->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="fecha"><i class="fas fa-calendar-alt"></i> Fecha</label>
                        <input type="date" name="fecha" class="form-control" 
                            value="{{ old('fecha', \Carbon\Carbon::parse($nota->fecha)->format('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="hora_inicio"><i class="fas fa-clock"></i> Hora Inicio</label>
                        <input type="time" name="hora_inicio" class="form-control" 
                            value="{{ old('hora_inicio', $nota->hora_inicio) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="hora_fin"><i class="fas fa-clock"></i> Hora Fin</label>
                        <input type="time" name="hora_fin" class="form-control" 
                            value="{{ old('hora_fin', $nota->hora_fin) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="tema"><i class="fas fa-heading"></i> Tema</label>
                    <input type="text" name="tema" class="form-control" 
                        value="{{ old('tema', $nota->tema) }}" placeholder="Resumen del tema tratado">
                </div>

                <div class="form-group">
                    <label for="contenido"><i class="fas fa-book"></i> Contenido</label>
                    <textarea name="contenido" class="form-control" rows="4" placeholder="Describe el contenido de la clase">{{ old('contenido', $nota->contenido) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="observaciones"><i class="fas fa-sticky-note"></i> Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones', $nota->observaciones) }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="usuario_id"><i class="fas fa-user"></i> Profesor</label>
                        <select name="usuario_id" class="form-control">
                            @foreach($profesores as $profesor)
                                <option value="{{ $profesor->id }}" {{ $profesor->id == $nota->usuario_id ? 'selected' : '' }}>
                                    {{ $profesor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="asignatura_id"><i class="fas fa-book-reader"></i> Asignatura</label>
                        <select name="asignatura_id" class="form-control">
                            @foreach($asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}" {{ $asignatura->id == $nota->asignatura_id ? 'selected' : '' }}>
                                    {{ $asignatura->nombre }} 
                                    @if($asignatura->profesor) - Prof. {{ $asignatura->profesor->name }} @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('notas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
