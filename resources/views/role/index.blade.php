@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="text-primary m-0"><i class="fas fa-user-shield"></i> Listado de Roles</h1>
    <a href="{{ route('role.create') }}" class="btn btn-outline-primary">
      <i class="fas fa-user-shield"></i> Alta Rol
  </a>
</div>
@stop

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <table id="tabla_data" class="table table-bordered table-striped table-hover">
            <thead class="bg-light">
                <tr>
                    <th>Nombre</th>
                    <th class="text-center" style="width: 250px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($roles as $role)
              <tr>
                  <td>{{ $role->name }}</td>
                  <td class="text-center">
                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-warning mr-1" title="Editar rol">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <button type="button" class="btn btn-sm btn-danger" 
                            data-toggle="modal" 
                            data-target="#deleteModal" 
                            data-id="{{ $role->id }}" 
                            title="Eliminar rol">
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
        ¿Estás seguro de que deseas eliminar este rol?
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
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function () {
    $('#tabla_data').DataTable({
        responsive: true,
        pageLength: 25,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });
});

$('#deleteModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let id = button.data('id');
    let action = '{{ route("role.destroy", ":id") }}';
    $('#deleteForm').attr('action', action.replace(':id', id));
});
</script>
@stop
