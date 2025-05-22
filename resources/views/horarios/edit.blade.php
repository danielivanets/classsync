@extends('adminlte::page')

@section('title', 'Editar Horario')

@section('content_header')
    <h1 class="mb-3">Editar Horario de la Asignatura: <strong>{{ $horario->asignatura->nombre }}</strong></h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Datos del Horario</h3>
            </div>

            <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="dia">Día *</label>
                        <select name="dia" id="dia" class="form-control @error('dia') is-invalid @enderror" required>
                            <option value="">Seleccione un día</option>
                            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $dia)
                                <option value="{{ $dia }}" {{ old('dia', $horario->dia) == $dia ? 'selected' : '' }}>
                                    {{ $dia }}
                                </option>
                            @endforeach
                        </select>
                        @error('dia')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hora_inicio">Hora de Inicio *</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" 
                               class="form-control @error('hora_inicio') is-invalid @enderror" 
                               value="{{ old('hora_inicio', $horario->hora_inicio) }}" required>
                        @error('hora_inicio')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hora_fin">Hora de Fin *</label>
                        <input type="time" name="hora_fin" id="hora_fin" 
                               class="form-control @error('hora_fin') is-invalid @enderror" 
                               value="{{ old('hora_fin', $horario->hora_fin) }}" required>
                        @error('hora_fin')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="aula_id">Aula *</label>
                        <select name="aula_id" id="aula_id" class="form-control @error('aula_id') is-invalid @enderror" required>
                            <option value="">Seleccione un aula</option>
                            @foreach($aulas as $aula)
                                <option value="{{ $aula->id }}" 
                                    {{ old('aula_id', $horario->aula_id) == $aula->id ? 'selected' : '' }}>
                                    {{ $aula->nombre }} ({{ $aula->tipo }})
                                </option>
                            @endforeach
                        </select>
                        @error('aula_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="asignatura_id">Asignatura *</label>
                        <select name="asignatura_id" id="asignatura_id"
                            class="form-control select2 @error('asignatura_id') is-invalid @enderror"
                            required>
                            <option value="">Seleccione una asignatura</option>
                            @foreach($asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}"
                                    {{ old('asignatura_id', $horario->asignatura_id) == $asignatura->id ? 'selected' : '' }}>
                                    {{ $asignatura->nombre }} 
                                    — {{ $asignatura->profesor->name ?? 'Sin profesor' }} 
                                    — {{ $asignatura->aula->nombre ?? 'Sin aula' }}
                                </option>
                            @endforeach
                        </select>
                        @error('asignatura_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('horarios.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop


@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#asignatura_id').select2({
                placeholder: "Seleccione una asignatura",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@stop

