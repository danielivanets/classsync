  @extends('adminlte::page')

  @section('title', 'Detalle de Asignatura')

  @section('content_header')
      <h4 class="mb-3"><i class="fas fa-book-open text-primary"></i> Detalles de Asignatura</h4>
  @stop

  @section('content')
  <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
          <div class="card shadow">
              <div class="card-header bg-primary text-white">
                  <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información de la Asignatura</h5>
              </div>

              <div class="card-body">
                  <p><strong><i class="fas fa-book text-muted mr-1"></i> Nombre:</strong> {{ $asignatura->nombre }}</p>
                  <p><strong><i class="fas fa-align-left text-muted mr-1"></i> Descripción:</strong> {{ $asignatura->descripcion ?? 'No disponible' }}</p>
                  <p><strong><i class="fas fa-chalkboard-teacher text-muted mr-1"></i> Profesor:</strong> {{ $asignatura->profesor ? $asignatura->profesor->name : 'No asignado' }}</p>
                  <p><strong><i class="fas fa-building text-muted mr-1"></i> Departamento:</strong> {{ $asignatura->departamento ? $asignatura->departamento->nombre : 'No asignado' }}</p>
                  <p><strong><i class="fas fa-door-open text-muted mr-1"></i> Aula:</strong> {{ $asignatura->aula ? $asignatura->aula->nombre . ' (' . $asignatura->aula->tipo . ')' : 'No asignado' }}</p>
                  <p><strong><i class="fas fa-calendar-plus text-muted mr-1"></i> Creado:</strong> {{ $asignatura->created_at->format('d/m/Y H:i') }}</p>
                  <p><strong><i class="fas fa-calendar-alt text-muted mr-1"></i> Última actualización:</strong> {{ $asignatura->updated_at->format('d/m/Y H:i') }}</p>
              </div>

              <div class="card-footer d-flex justify-content-between">
                  <a href="{{ route('asignaturas.index') }}" class="btn btn-secondary">
                      <i class="fas fa-arrow-left"></i> Volver
                  </a>
                  @can('administrar')
                    <div>
                        <a href="{{ route('asignaturas.edit', $asignatura) }}" class="btn btn-warning mr-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <!-- Botón para abrir modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </div>
                  @endcan
              </div>
          </div>
      </div>
  </div>

  <!-- Modal de Confirmación -->
  <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="modal-delete-label"><i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar la asignatura <strong>{{ $asignatura->nombre }}</strong>? Esta acción no se puede deshacer.
        </div>
        <div class="modal-footer">
          <form action="{{ route('asignaturas.destroy', $asignatura) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @stop

  @section('css')
  @stop

  @section('js')
  @stop
