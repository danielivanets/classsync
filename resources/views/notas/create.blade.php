@extends('adminlte::page')

@section('title', 'Crear Nota de Clase')

@section('content_header')
    <h4 class="mb-3"><i class="fas fa-sticky-note text-primary"></i> Nueva Nota de Clase</h4>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-book-open"></i> Detalles de la Nota</h5>
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

            <form action="{{ route('notas.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">

                        {{-- Profesor --}}
                        <div class="form-group col-md-6">
                            <label for="usuario_id"><i class="fas fa-user mr-1 text-muted"></i> Profesor *</label>
                            <select class="form-control @error('usuario_id') is-invalid @enderror" name="usuario_id" required>
                                <option value="">Seleccione un profesor</option>
                                @foreach($profesores as $profesor)
                                    <option value="{{ $profesor->id }}" {{ old('usuario_id') == $profesor->id ? 'selected' : '' }}>{{ $profesor->name }}</option>
                                @endforeach
                            </select>
                            @error('usuario_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        {{-- Asignatura --}}
                        <div class="form-group col-md-6">
                            <label for="asignatura_id"><i class="fas fa-book mr-1 text-muted"></i> Asignatura *</label>
                            <select class="form-control @error('asignatura_id') is-invalid @enderror" name="asignatura_id" required>
                                <option value="">Seleccione una asignatura</option>
                                @foreach($todasAsignaturas as $asignatura)
                                    <option value="{{ $asignatura->id }}" {{ old('asignatura_id') == $asignatura->id ? 'selected' : '' }}>
                                        {{ $asignatura->nombre }} 
                                        @if($asignatura->profesor) - Prof. {{ $asignatura->profesor->name }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('asignatura_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        {{-- Fecha --}}
                        <div class="form-group col-md-4">
                            <label for="fecha"><i class="fas fa-calendar-day mr-1 text-muted"></i> Fecha *</label>
                            <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', date('Y-m-d')) }}" required>
                            @error('fecha') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        {{-- Hora Inicio --}}
                        <div class="form-group col-md-4">
                            <label for="hora_inicio"><i class="fas fa-hourglass-start mr-1 text-muted"></i> Hora Inicio</label>
                            <input type="time" name="hora_inicio" class="form-control @error('hora_inicio') is-invalid @enderror" value="{{ old('hora_inicio') }}">
                            @error('hora_inicio') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        {{-- Hora Fin --}}
                        <div class="form-group col-md-4">
                            <label for="hora_fin"><i class="fas fa-hourglass-end mr-1 text-muted"></i> Hora Fin</label>
                            <input type="time" name="hora_fin" class="form-control @error('hora_fin') is-invalid @enderror" value="{{ old('hora_fin') }}">
                            @error('hora_fin') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        {{-- Tema --}}
                        <div class="form-group col-md-12">
                            <label for="tema"><i class="fas fa-heading mr-1 text-muted"></i> Tema</label>
                            <input type="text" name="tema" class="form-control @error('tema') is-invalid @enderror" value="{{ old('tema') }}" placeholder="Tema tratado (opcional)">
                            @error('tema') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        {{-- Contenido --}}
                        <div class="form-group col-md-12">
                            <label for="contenido"><i class="fas fa-align-left mr-1 text-muted"></i> Contenido *</label>
                            <textarea name="contenido" class="form-control @error('contenido') is-invalid @enderror" rows="4" placeholder="Detalle del contenido de la clase..." required>{{ old('contenido') }}</textarea>
                            @error('contenido') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        {{-- Observaciones --}}
                        <div class="form-group col-md-12">
                            <label for="observaciones"><i class="fas fa-comment-dots mr-1 text-muted"></i> Observaciones</label>
                            <textarea name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="3">{{ old('observaciones') }}</textarea>
                            @error('observaciones') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('notas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus mr-1"></i> Crear Nota
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
