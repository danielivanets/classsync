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
                                        data-departamento-id="{{ $profesor->departamento_id }}"
                                    {{ old('usuario_id', $asignatura->usuario_id) == $profesor->id ? 'selected' : '' }}>
                                    {{ $profesor->name }} ({{ $profesor->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('usuario_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="departamento_id">
                            <i class="fas fa-building mr-1 text-muted"></i> Departamento
                        </label>

                        {{-- Select visible solo para mostrar --}}
                        <select id="departamento_id_display" class="form-control" disabled>
                            <option value="">Seleccione un departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" 
                                    {{ old('departamento_id', $asignatura->departamento_id) == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="departamento_id" id="departamento_id" 
                            value="{{ old('departamento_id', $asignatura->departamento_id) }}">
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
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
@stop
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#usuario_id').select2({
            theme: 'bootstrap4',
            placeholder: "Seleccione un profesor",
            allowClear: true,
            width: 'resolve'
        });
        const departamentoDisplay = $('#departamento_id_display');
        const departamentoHidden = $('#departamento_id');

        $('#usuario_id').on('change', function () {
            const selectedOption = $(this).find('option:selected');
            const departamentoId = selectedOption.data('departamento-id');

            if (departamentoId) {
                departamentoDisplay.val(departamentoId);
                departamentoHidden.val(departamentoId);
            } else {
                departamentoDisplay.val('');
                departamentoHidden.val('');
            }

            departamentoDisplay.trigger('change');
        });

        // Disparar evento para cargar con old() o el valor actual
        $('#usuario_id').trigger('change');

        
        $('#aula_id').select2({
            theme: 'bootstrap4',
            placeholder: "Seleccione un aula",
            allowClear: true,
            width: 'resolve'
        });
    });
</script>
@stop

