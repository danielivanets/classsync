@extends('adminlte::page')

@section('title', 'Lista de Usuarios')

@section('content_header')
    <h1 class="text-primary">Gestión de Usuarios</h1>
@stop

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><i class="fas fa-users text-primary"></i> Usuarios Registrados</h3>
        <div>
            <a href="{{ route('admin.create') }}" class="btn btn-outline-primary mr-2">
                <i class="fas fa-user-plus"></i> Alta Usuario
            </a>
            <a href="{{ route('role.create') }}" class="btn btn-outline-secondary">
                <i class="fas fa-user-shield"></i> Alta Rol
            </a>
            <!-- Botón -->
            <button class="btn btn-info" data-toggle="modal" data-target="#modalTodosUsuarios">
                <i class="fas fa-database"></i> Ver Todos los Registros
            </button>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="usuarios" class="table table-bordered table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <!--<th>ID</th>-->
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th class="text-center" style="width: 250px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $usuario)
                        <tr>
                            {{--<td>{{ $usuario->id }}</td>--}}
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @foreach($usuario->getRoleNames() as $rol)
                                    <span class="badge bg-info">{{ $rol }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.edit', $usuario->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <button type="button" class="btn btn-sm btn-danger" 
                                        data-toggle="modal" 
                                        data-target="#deleteModal" 
                                        data-id="{{ $usuario->id }}"
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

<!-- Modal -->
<div class="modal fade" id="modalTodosUsuarios" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Todos los Usuarios del Sistema</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tablaTodosUsuarios" class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Rol</th>
              <th>Visible</th>
            </tr>
          </thead>
          <tbody>
            @foreach($todosUsuarios as $u)
              <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->getRoleNames()->join(', ') }}</td>
                <td>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input toggle-visible" 
                             id="visibleSwitch{{ $u->id }}" 
                             data-id="{{ $u->id }}" 
                             {{ $u->visible ? 'checked' : '' }}>
                      <label class="custom-control-label" for="visibleSwitch{{ $u->id }}"></label>
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
                    ¿Estás seguro de que deseas eliminar este usuario?
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
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
            $('#usuarios').DataTable({
                language: {
                    url: '/js/i18n/es-ES.json'
                },
                responsive: true,
                autoWidth: false,
                pageLength: 25
            });
    
            $('#tablaTodosUsuarios').DataTable({
                language: {
                    url: '/js/i18n/es-ES.json'
                },
                pageLength: 10,
                responsive: true
            });
    
            // Mostrar mensajes Toastr desde session
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
            let action = '{{ route("admin.destroy", ":id") }}';
            $('#deleteForm').attr('action', action.replace(':id', id));
        });
    
        $(document).on('change', '.toggle-visible', function () {
            let userId = $(this).data('id');
            let isVisible = $(this).is(':checked');
    
            $.ajax({
                url: `/admin/${userId}/toggle-visible`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    visible: isVisible ? 1 : 0
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(`Usuario ID ${userId}: visibilidad actualizada a ${response.visible ? 'Sí' : 'No'}`, 'Actualización exitosa');
                    } else {
                        toastr.warning(`Usuario ID ${userId}: no se pudo actualizar la visibilidad.`, 'Atención');
                    }
                },
                error: function() {
                    toastr.error('Error al actualizar visibilidad del usuario.', 'Error');
                }
            });
        });
    
        $('#modalTodosUsuarios').on('hidden.bs.modal', function () {
            location.reload();
        });
    </script>

        
@stop
