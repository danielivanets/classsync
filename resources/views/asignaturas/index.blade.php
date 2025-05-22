@extends('adminlte::page')

@section('title', 'Asignaturas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0 text-primary">
        <i class="fas fa-book mr-2"></i>Listado de Asignaturas
    </h3>
    <div>
        <a href="{{ route('asignaturas.create') }}" class="btn btn-outline-primary mr-2">
            <i class="fas fa-plus"></i> Nueva Asignatura
        </a>
        <button class="btn btn-info" data-toggle="modal" data-target="#modalTodasAsignaturas">
            <i class="fas fa-database"></i> Ver Todos los Registros
        </button>
    </div>
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

@if($asignaturas->count())
<div class="card shadow-sm">
    <div class="card-body">
        <table id="asignaturas" class="table table-bordered table-striped table-hover">
            <thead class="bg-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Profesor</th>
                    <th>Departamento</th>
                    <th>Aula</th>
                    <th class="text-center" style="width: 250px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaturas as $asignatura)
                    <tr>
                        <td>{{ $asignatura->id }}</td>
                        <td>{{ $asignatura->nombre }}</td>
                        <td>{{ $asignatura->profesor?->name ?? 'Sin asignar' }}</td>
                        <td>{{ $asignatura->departamento?->nombre ?? 'Sin asignar' }}</td>
                        <td>{{ $asignatura->aula?->tipo ?? 'Sin asignar' }}</td>
                        <td class="text-center">
                            <a href="{{ route('asignaturas.show', $asignatura) }}" class="btn btn-sm btn-info" title="Ver">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('asignaturas.edit', $asignatura) }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" 
                                    data-toggle="modal" 
                                    data-target="#deleteModal" 
                                    data-id="{{ $asignatura->id }}" 
                                    title="Eliminar">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para Ver Todos los Registros -->
<div class="modal fade" id="modalTodasAsignaturas" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Todos las Asignaturas</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tablaTodasAsignaturas" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Profesor</th>
              <th>Departamento</th>
              <th>Aula</th>
              <th>Visible</th>
            </tr>
          </thead>
          <tbody>
            @foreach($todasAsignaturas as $a)
              <tr>
                <td>{{ $a->id }}</td>
                <td>{{ $a->nombre }}</td>
                <td>{{ $a->profesor?->name ?? 'Sin asignar' }}</td>
                <td>{{ $a->departamento?->nombre ?? 'Sin asignar' }}</td>
                <td>{{ $a->aula?->tipo ?? 'Sin asignar' }}</td>
                <td>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input toggle-visible" 
                             id="visibleSwitch{{ $a->id }}" 
                             data-id="{{ $a->id }}" 
                             {{ $a->visible ? 'checked' : '' }}>
                      <label class="custom-control-label" for="visibleSwitch{{ $a->id }}"></label>
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

<!-- Modal Confirmación Eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar esta asignatura?
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
    <p>No hay asignaturas registradas.</p>
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
            $('#asignaturas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                responsive: true,
                autoWidth: false,
                pageLength: 10
            });

            $('#tablaTodasAsignaturas').DataTable({
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
            let action = '{{ route("asignaturas.destroy", ":id") }}';
            $('#deleteForm').attr('action', action.replace(':id', id));
        });

        $(document).on('change', '.toggle-visible', function () {
            let asignaturaId = $(this).data('id');
            let isVisible = $(this).is(':checked');

            $.ajax({
                url: `/asignaturas/${asignaturaId}/toggle-visible`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    visible: isVisible ? 1 : 0
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(`Asignatura ID ${asignaturaId}: visibilidad actualizada a ${response.visible ? 'Sí' : 'No'}`, 'Actualización exitosa');
                    } else {
                        toastr.warning(`Asignatura ID ${asignaturaId}: no se pudo actualizar la visibilidad.`, 'Atención');
                    }
                },
                error: function() {
                    toastr.error('Error al actualizar visibilidad de la asignatura.', 'Error');
                }
            });
        });

        $('#modalTodasAsignaturas').on('hidden.bs.modal', function () {
            location.reload();
        });
    </script>
@stop
