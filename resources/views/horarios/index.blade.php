@extends('adminlte::page')

@section('title', 'Horarios')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0 text-primary">
        <i class="fas fa-clock mr-2"></i>Listado de Horarios
    </h3>
    @can('administrar')
        <div>
            <a href="{{ route('horarios.create') }}" class="btn btn-outline-primary mr-2">
                <i class="fas fa-plus"></i> Nuevo Horario
            </a>
            <button class="btn btn-info" data-toggle="modal" data-target="#modalTodosHorarios">
                <i class="fas fa-database"></i> Ver Todos los Registros
            </button>
        </div>
    @endcan
</div>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($horarios->count())
<div class="card shadow-sm">
    <div class="card-body">
        <table id="horarios" class="table table-bordered table-striped table-hover">
            <thead class="bg-light">
                <tr>
                    @can('administrar')<th>ID</th>@endcan
                    <th>Día</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Asignatura</th>
                    <th>Aula</th>
                    <th>Profesor</th>
                    @can('administrar')<th class="text-center" style="width: 250px;">Acciones</th>@endcan
                </tr>
            </thead>
            <tbody>
                @foreach($horarios as $horario)
                <tr>
                    @can('administrar')<td>{{ $horario->id }}</td>@endcan
                    <td>{{ $horario->dia }}</td>
                    <td>{{ $horario->hora_inicio }}</td>
                    <td>{{ $horario->hora_fin }}</td>
                    <td>{{ $horario->asignatura?->nombre ?? 'Sin asignar' }}</td>
                    <td>{{ $horario->aula?->nombre ?? 'Sin asignar' }}</td>
                    <td>{{ $horario->asignatura?->profesor?->name ?? 'Sin asignar' }}</td> <!-- Nuevo -->
                    @can('administrar')<td class="text-center">
                        <a href="{{ route('horarios.edit', $horario) }}" class="btn btn-sm btn-warning" title="Editar">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-sm btn-danger"
                            data-toggle="modal"
                            data-target="#deleteModal"
                            data-id="{{ $horario->id }}">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </td>@endcan
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Todos los horarios -->
<div class="modal fade" id="modalTodosHorarios" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Todos los Horarios</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tablaTodosHorarios" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Día</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Asignatura</th>
                    <th>Aula</th>
                    <th>Visible</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todosHorarios as $h)
                <tr>
                    <td>{{ $h->id }}</td>
                    <td>{{ $h->dia }}</td>
                    <td>{{ $h->hora_inicio }}</td>
                    <td>{{ $h->hora_fin }}</td>
                    <td>{{ $h->asignatura?->nombre ?? 'Sin asignar' }}</td>
                    <td>{{ $h->aula?->nombre ?? 'Sin asignar' }}</td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input toggle-visible"
                                id="visibleSwitch{{ $h->id }}"
                                data-id="{{ $h->id }}"
                                {{ $h->visible ? 'checked' : '' }}>
                            <label class="custom-control-label" for="visibleSwitch{{ $h->id }}"></label>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Confirmar eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Eliminar Horario</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar este horario?
      </div>
      <div class="modal-footer">
        <form method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@else
    <p>No hay horarios registrados.</p>
@endif
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        $('#horarios').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            responsive: true,
            autoWidth: false,
            pageLength: 10
        });

        $('#tablaTodosHorarios').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            responsive: true
        });

        @if(session('success'))
            toastr.success("{{ session('success') }}", 'Éxito');
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}", 'Error');
        @endif
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let action = '{{ route("horarios.destroy", ":id") }}';
        $('#deleteForm').attr('action', action.replace(':id', id));
    });

    $(document).on('change', '.toggle-visible', function () {
        let horarioId = $(this).data('id');
        let isVisible = $(this).is(':checked');

        $.ajax({
            url: `/horarios/${horarioId}/toggle-visible`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                visible: isVisible ? 1 : 0
            },
            success: function(response) {
                toastr.success('Visibilidad actualizada correctamente.');
            },
            error: function() {
                toastr.error('Error al actualizar visibilidad.');
            }
        });
    });

    $('#modalTodosHorarios').on('hidden.bs.modal', function () {
        location.reload();
    });
</script>
@stop
