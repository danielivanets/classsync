@extends('adminlte::page')

@section('title', 'Crear Horario')

@section('content_header')
    <h4 class="mb-3"><i class="fas fa-clock text-primary"></i> Nuevo Horario</h4>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Datos del Horario</h5>
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

            <form action="{{ route('horarios.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="dia"><i class="fas fa-calendar-day mr-1 text-muted"></i> Día *</label>
                        <select class="form-control @error('dia') is-invalid @enderror" id="dia" name="dia" required>
                            <option value="">Seleccione un día</option>
                            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                                <option value="{{ $dia }}" {{ old('dia') == $dia ? 'selected' : '' }}>{{ $dia }}</option>
                            @endforeach
                        </select>
                        @error('dia')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hora_inicio"><i class="fas fa-hourglass-start mr-1 text-muted"></i> Hora de Inicio *</label>
                        <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio') }}" required>
                        @error('hora_inicio')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hora_fin"><i class="fas fa-hourglass-end mr-1 text-muted"></i> Hora de Fin *</label>
                        <input type="time" class="form-control @error('hora_fin') is-invalid @enderror" id="hora_fin" name="hora_fin" value="{{ old('hora_fin') }}" required>
                        @error('hora_fin')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="aula_id"><i class="fas fa-door-open mr-1 text-muted"></i> Aula *</label>
                        <select class="form-control @error('aula_id') is-invalid @enderror" id="aula_id" name="aula_id" required>
                            <option value="">Seleccione un aula</option>
                            @foreach($aulas as $aula)
                                <option value="{{ $aula->id }}" {{ old('aula_id') == $aula->id ? 'selected' : '' }}>
                                    {{ $aula->nombre }} ({{ $aula->tipo }})
                                </option>
                            @endforeach
                        </select>
                        @error('aula_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="asignatura_id"><i class="fas fa-book mr-1 text-muted"></i> Asignatura *</label>
                        <select class="form-control @error('asignatura_id') is-invalid @enderror" id="asignatura_id" name="asignatura_id" required>
                            <option value="">Seleccione una asignatura</option>
                            @foreach($asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}" {{ old('asignatura_id') == $asignatura->id ? 'selected' : '' }}>
                                    {{ $asignatura->nombre }}
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
                        <i class="fas fa-plus mr-1"></i> Crear Horario
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
