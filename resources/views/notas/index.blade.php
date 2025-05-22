@extends('adminlte::page')

@section('title', 'Lista de Notas de Clase')

@section('content_header')
    <h1 class="text-primary">Gestión de Notas de Clase</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><i class="fas fa-sticky-note text-primary"></i> Notas Registradas</h3>
        <div>
            <a href="{{ route('notas.create') }}" class="btn btn-outline-primary mr-2">
                <i class="fas fa-plus-circle"></i> Nueva Nota
            </a>
            <button class="btn btn-info" data-toggle="modal" data-target="#modalTodasNotas">
                <i class="fas fa-database"></i> Ver Todas las Notas
            </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="notas" class="table table-bordered table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Asignatura</th>
                        <th>Profesor</th>
                        <th>Tema</th>
                        <th class="text-center" style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notas as $nota)
                        <tr>
                            <td>{{ $nota->fecha }}</td>
                            <td>{{ $nota->hora_inicio ?? '--' }} - {{ $nota->hora_fin ?? '--' }}</td>
                            <td>{{ $nota->asignatura->nombre ?? 'N/A' }}</td>
                            <td>{{ $nota->usuario->name ?? 'N/A' }}</td>
                            <td>{{ Str::limit($nota->tema, 30) }}</td>
                            <td class="text-center">
                                <a href="{{ route('notas.edit', $nota->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <button type="button" class="btn btn-sm btn-danger" 
                                        data-toggle="modal" 
                                        data-target="#deleteModal" 
                                        data-id="{{ $nota->id }}">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                    ¿Estás seguro de que deseas eliminar esta nota?
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

    <!-- Modal Todas las Notas -->
    <div class="modal fade" id="modalTodasNotas" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Todas las Notas del Sistema</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="tablaTodasNotas" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Asignatura</th>
                                <th>Profesor</th>
                                <th>Tema</th>
                                <th>Visible</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($todasNotas as $nota)
                                <tr>
                                    <td>{{ $nota->id }}</td>
                                    <td>{{ $nota->fecha }}</td>
                                    <td>{{ $nota->hora_inicio ?? '--' }}</td>
                                    <td>{{ $nota->hora_fin ?? '--' }}</td>
                                    <td>{{ $nota->asignatura->nombre ?? 'N/A' }}</td>
                                    <td>{{ $nota->usuario->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($nota->tema, 30) }}</td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input toggle-visible-nota" 
                                                   id="visibleSwitchNota{{ $nota->id }}" 
                                                   data-id="{{ $nota->id }}" 
                                                   {{ $nota->visible ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="visibleSwitchNota{{ $nota->id }}"></label>
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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
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
            $('#notas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                responsive: true,
                autoWidth: false,
                pageLength: 10
            });

            $('#tablaTodasNotas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                responsive: true
            });

            $('#modalTodasNotas').on('show.bs.modal', function () {
                toastr.info('Puedes cambiar la visibilidad de las notas directamente desde esta vista.', 'Información');
            });
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let id = button.data('id');
            let action = '{{ route("notas.destroy", ":id") }}';
            $('#deleteForm').attr('action', action.replace(':id', id));
        });

        // Toggle visibilidad via AJAX
        $(document).on('change', '.toggle-visible-nota', function () {
            let notaId = $(this).data('id');
            let isVisible = $(this).is(':checked');
            let fila = $(this).closest('tr');
            let tema = fila.find('td:nth-child(7)').text().trim();

            $.ajax({
                url: `/notas/${notaId}/toggle-visible`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    visible: isVisible ? 1 : 0
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(`Nota "${tema}" (ID ${notaId}) actualizada a: ${response.visible ? 'Visible' : 'Oculta'}`, 'Visibilidad actualizada');
                    } else {
                        toastr.warning('La operación no fue completada correctamente.', 'Aviso');
                    }
                },
                error: function() {
                    toastr.error('Error al actualizar visibilidad de la nota. Inténtalo de nuevo.', 'Error');
                }
            });
        });

        // Recarga la página cuando se cierre el modal
        $('#modalTodasNotas').on('hidden.bs.modal', function () {
            toastr.info('Cierre del modal. Actualizando los datos...', 'Actualización');
            setTimeout(() => location.reload(), 1000);
        });

        // Toastr para mensajes de sesión
        @if(session('success'))
            toastr.success("{{ session('success') }}", 'Éxito');
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}", 'Error');
        @endif
    </script>
@stop
