@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    <h1 class="text-primary"><i class="fas fa-key"></i> Permisos</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Lista de Permisos</h3>
        <a href="{{ route('permissions.create') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Permiso
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="permisos" class="table table-bordered table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Guard</th>
                        <th class="text-center" style="width: 160px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                            <td class="text-center">
                                <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#deleteModal" 
                                        data-id="{{ $permission->id }}"
                                        data-nombre="{{ $permission->name }}"
                                        title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    @if($permissions->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center text-muted">No hay permisos registrados.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Confirmación de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro que deseas eliminar el permiso <strong id="permisoNombre"></strong>?</p>
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
            $('#permisos').DataTable({
                language: {
                    url: '/js/i18n/es-ES.json'
                },
                responsive: true,
                autoWidth: false,
                pageLength: 10
            });
    });


    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let nombre = button.data('nombre');
        let modal = $(this);

        // Actualiza el texto con el nombre del permiso
        modal.find('#permisoNombre').text(nombre);

        // Actualiza el action del formulario para enviar al método DELETE correcto
        let action = '{{ route("permissions.destroy", ":id") }}';
        action = action.replace(':id', id);
        modal.find('#deleteForm').attr('action', action);
    });
</script>
@stop
