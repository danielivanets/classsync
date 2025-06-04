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
                    <th>Orden Día</th>
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
                    <td>
                        {{
                            ['Lunes' => 1, 'Martes' => 2, 'Miércoles' => 3, 'Jueves' => 4, 'Viernes' => 5][$horario->dia] ?? 6
                        }}
                    </td>
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


@can('administrar')
  <div class="container-fluid" style="display: none">
    <div class="row">
      <!-- Panel izquierdo (eventos arrastrables) -->
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Eventos arrastrables</h4>
          </div>
          <div class="card-body">
            <div id="external-events">
              <div class="external-event bg-success">Asignatura 1</div>
              <div class="external-event bg-warning">Asignatura 2</div>
              <!-- ... más eventos ... -->
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" id="drop-remove"> Eliminar al soltar
              </label>
            </div>
          </div>
        </div>
        <!-- Formulario para crear eventos -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Crear evento</h3>
          </div>
          <div class="card-body">
            <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
              <ul class="fc-color-picker" id="color-chooser">
                <li><a class="text-primary active" href="#"><i class="fas fa-square"></i></a></li>
                <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
              </ul>
            </div>
            <div class="input-group">
              <input id="new-event" type="text" class="form-control" placeholder="Título del evento">
              <div class="input-group-append">
                <button id="add-new-event" type="button" class="btn btn-primary">Añadir</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Calendario principal -->
      <div class="col-md-9">
        <div class="card card-primary">
          <div class="card-body p-0">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endcan





@else
    <p>No hay horarios registrados.</p>
@endif
@stop


@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5/main.min.css">
    <style>
        .external-event {
            padding: 5px 10px;
            margin: 5px 0;
            cursor: move;
            color: #fff;
            border-radius: 3px;
        }
    </style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5/locales/es.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function () {
        $('#horarios').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            columnDefs: [
                { targets: 1, visible: false }, // Oculta columna de orden de días
            ],
            order: [1, 'asc'],
            dom: '<"row mb-2"<"col-sm-6"l><"col-sm-6 d-flex justify-content-end align-items-center"B>>' + 
                '<"row"<"col-sm-12"f>>' +
                '<"row"<"col-sm-12 table-responsive"tr>>' +
                '<"row mt-2"<"col-sm-5"i><"col-sm-7"p>>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
                    className: 'btn btn-success mb-3',
                    titleAttr: 'Exportar a Excel',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluye la columna de acciones si es la última
                    }
                }
            ]
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

////////////////////////////////////////////////////////////////
//////////// PENDIENTE PARA ADAPTAR A LA SISTEMA ///////////////
////////////////////////////////////////////////////////////////

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar FullCalendar
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            editable: true, // Permite arrastrar/redimensionar eventos
            droppable: true, // Permite soltar eventos externos
            events: [
                // Eventos iniciales (opcional)
                { title: 'Meeting', start: '2025-06-02T10:30:00', color: '#0073b7' },
                { title: 'Lunch', start: '2025-06-02T12:00:00', color: '#00c0ef' }
            ],
            drop: function(info) {
                // Lógica al soltar un evento externo
                if (document.getElementById('drop-remove').checked) {
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                }
            }
        });
        calendar.render();



         // Habilitar arrastre para eventos externos
        const externalEvents = document.getElementById('external-events');
        new FullCalendar.Draggable(externalEvents, {
            itemSelector: '.external-event',
            eventData: function(eventEl) {
            return {
                title: eventEl.innerText,
                backgroundColor: window.getComputedStyle(eventEl).backgroundColor
            };
            }
        });

        document.querySelectorAll('#color-chooser li a').forEach(el => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('#color-chooser li a').forEach(a => a.classList.remove('active'));
                this.classList.add('active');
            });
        });
        // Añadir nuevos eventos
        document.getElementById('add-new-event').addEventListener('click', function () {
            const title = document.getElementById('new-event').value.trim();
            const activeColorEl = document.querySelector('#color-chooser li a.active');

            if (title && activeColorEl) {
                // Obtener solo la clase de color (ej. 'text-primary')
                const colorClass = [...activeColorEl.classList].find(cls => cls.startsWith('text-'));
                const colorName = colorClass?.split('-')[1] || 'primary'; // por si acaso

                const eventEl = document.createElement('div');
                eventEl.className = `external-event bg-${colorName}`;
                eventEl.innerText = title;

                document.getElementById('external-events').appendChild(eventEl);
                document.getElementById('new-event').value = '';
            } else {
                alert('Debe ingresar un título y seleccionar un color');
            }
        });
    });
///////////////////////////////////////////////////////////
</script>
@stop
