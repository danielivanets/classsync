@extends('adminlte::page')

@section('title', 'Lista de Aulas')

@section('content_header')
    <h1 class="text-primary">Gestión de Aulas</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><i class="fas fa-school text-primary"></i> Aulas Registradas</h3>
        <div>

            <a href="{{ route('aulas.create') }}" class="btn btn-outline-primary mr-2">
                <i class="fas fa-plus-circle"></i> Alta Aula
            </a>
            <button class="btn btn-info" data-toggle="modal" data-target="#modalTodasAulas">
                <i class="fas fa-database"></i> Ver Todos los Registros
            </button>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="aulas" class="table table-bordered table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Capacidad</th>
                        <th>Tipo</th>
                        <th>Ubicación</th>
                        <th>Disponible</th>
                        <th class="text-center" style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aulas as $aula)
                        <tr>
                            <td>{{ $aula->nombre }}</td>
                            <td>{{ $aula->capacidad }}</td>
                            <td>{{ ucfirst($aula->tipo) }}</td>
                            <td>{{ $aula->ubicacion }}</td>
                            <td>
                                @if($aula->disponible)
                                    <span class="badge badge-success">Sí</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('aulas.edit', $aula->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <button type="button" class="btn btn-sm btn-danger" 
                                        data-toggle="modal" 
                                        data-target="#deleteModal" 
                                        data-id="{{ $aula->id }}">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
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
                    ¿Estás seguro de que deseas eliminar esta aula?
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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    <!-- Modal -->
<div class="modal fade" id="modalTodasAulas" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">Todas las Aulas del Sistema</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="tablaTodasAulas" class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Capacidad</th>
                <th>Tipo</th>
                <th>Ubicación</th>
                <th>Disponible</th>
                <th>Visible</th>
              </tr>
            </thead>
            <tbody>
              @foreach($todasAulas as $aula)
                <tr>
                  <td>{{ $aula->id }}</td>
                  <td>{{ $aula->nombre }}</td>
                  <td>{{ $aula->capacidad }}</td>
                  <td>{{ ucfirst($aula->tipo) }}</td>
                  <td>{{ $aula->ubicacion ?? 'No especificada' }}</td>
                  <td>
                    <span class="badge {{ $aula->disponible ? 'badge-success' : 'badge-danger' }}">
                        {{ $aula->disponible ? 'Sí' : 'No' }}
                    </span>
                  </td>
                  <td>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input toggle-visible-aula" 
                             id="visibleSwitchAula{{ $aula->id }}" 
                             data-id="{{ $aula->id }}" 
                             {{ $aula->visible ? 'checked' : '' }}>
                      <label class="custom-control-label" for="visibleSwitchAula{{ $aula->id }}"></label>
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
            $('#aulas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                responsive: true,
                autoWidth: false,
                pageLength: 10
            });

            $('#tablaTodasAulas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                responsive: true
            });

            // Mensaje informativo al abrir modal
            $('#modalTodasAulas').on('show.bs.modal', function () {
                toastr.info('Puedes cambiar la visibilidad de las aulas directamente desde esta vista.', 'Información');
            });
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let id = button.data('id');
            let action = '{{ route("aulas.destroy", ":id") }}';
            $('#deleteForm').attr('action', action.replace(':id', id));
        });

        // Toastr para cambio de visibilidad
        $(document).on('change', '.toggle-visible-aula', function () {
            let aulaId = $(this).data('id');
            let isVisible = $(this).is(':checked');
            let fila = $(this).closest('tr');
            let nombreAula = fila.find('td:nth-child(2)').text().trim(); // Se asume que el nombre está en la 2ª columna

            $.ajax({
                url: `/aulas/${aulaId}/toggle-visible`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    visible: isVisible ? 1 : 0
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(`Aula "${nombreAula}" (ID ${aulaId}) actualizada a: ${response.visible ? 'Visible' : 'Oculta'}`, 'Visibilidad actualizada');
                    } else {
                        toastr.warning('La operación no fue completada correctamente.', 'Aviso');
                    }
                },
                error: function() {
                    toastr.error('Error al actualizar visibilidad del aula. Inténtalo de nuevo.', 'Error');
                }
            });
        });

        // Recarga la página cuando se cierre el modal
        $('#modalTodasAulas').on('hidden.bs.modal', function () {
            toastr.info('Cierre del modal. Actualizando los datos...', 'Actualización');
            setTimeout(() => location.reload(), 1000);
        });

        // Toastr para mensajes de sesión (éxito o error)
        @if(session('success'))
            toastr.success("{{ session('success') }}", 'Éxito');
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}", 'Error');
        @endif
    </script>
@stop

