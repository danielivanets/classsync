@extends('adminlte::page')

@section('title', 'Editar Asignatura')

@section('content_header')
    <h1 class="mb-3">Editar Asignatura: <strong>{{ $asignatura->nombre }}</strong></h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Datos de la Asignatura</h3>
            </div>

            <form action="{{ route('asignaturas.update', $asignatura->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre', $asignatura->nombre) }}" required>
                        @error('nombre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" 
                                  class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $asignatura->descripcion) }}</textarea>
                        @error('descripcion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="usuario_id">Profesor</label>
                        <select name="usuario_id" id="usuario_id" class="form-control @error('usuario_id') is-invalid @enderror">
                            <option value="">Seleccione un profesor</option>
                            @foreach($profesores as $profesor)
                                <option value="{{ $profesor->id }}" 
                                    {{ old('usuario_id', $asignatura->usuario_id) == $profesor->id ? 'selected' : '' }}>
                                    {{ $profesor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('usuario_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="departamento_id">Departamento</label>
                        <select name="departamento_id" id="departamento_id" class="form-control @error('departamento_id') is-invalid @enderror">
                            <option value="">Seleccione un departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" 
                                    {{ old('departamento_id', $asignatura->departamento_id) == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('departamento_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="aula_id">Aula</label>
                        <select name="aula_id" id="aula_id" class="form-control @error('aula_id') is-invalid @enderror">
                            <option value="">Seleccione un aula</option>
                            @foreach($aulas as $aula)
                                <option value="{{ $aula->id }}" 
                                    {{ old('aula_id', $asignatura->aula_id) == $aula->id ? 'selected' : '' }}>
                                    {{ $aula->nombre }} ({{ $aula->tipo }})
                                </option>
                            @endforeach
                        </select>
                        @error('aula_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('asignaturas.index') }}" class="btn btn-secondary mr-2">
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
