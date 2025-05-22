@extends('adminlte::page')

@section('title', 'Crear Asignatura')

@section('content_header')
    <h4 class="mb-3"><i class="fas fa-book text-primary"></i> Nueva Asignatura</h4>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-id-card-alt"></i> Datos de la Asignatura</h5>
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

            <form action="{{ route('asignaturas.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre"><i class="fas fa-book mr-1 text-muted"></i> Nombre *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" 
                               value="{{ old('nombre') }}" placeholder="Ej. Matemáticas" required>
                        @error('nombre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion"><i class="fas fa-align-left mr-1 text-muted"></i> Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3" placeholder="Descripción de la asignatura">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="usuario_id"><i class="fas fa-chalkboard-teacher mr-1 text-muted"></i> Profesor</label>
                        <select class="form-control @error('usuario_id') is-invalid @enderror" id="usuario_id" name="usuario_id">
                            <option value="">Seleccione un profesor</option>
                            @foreach($profesores as $profesor)
                                <option value="{{ $profesor->id }}" {{ old('usuario_id') == $profesor->id ? 'selected' : '' }}>
                                    {{ $profesor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('usuario_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="departamento_id"><i class="fas fa-building mr-1 text-muted"></i> Departamento</label>
                        <select class="form-control @error('departamento_id') is-invalid @enderror" id="departamento_id" name="departamento_id">
                            <option value="">Seleccione un departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('departamento_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="aula_id"><i class="fas fa-door-open mr-1 text-muted"></i> Aula</label>
                        <select class="form-control @error('aula_id') is-invalid @enderror" id="aula_id" name="aula_id">
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
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('asignaturas.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus mr-1"></i> Crear Asignatura
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
