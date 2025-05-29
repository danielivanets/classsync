{{-- resources/views/home.blade.php --}}
@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1 class="text-primary">Bienvenido al Panel</h1>
@stop

@section('content')
    <div class="row">
        {{-- Card de bienvenida --}}
        <div class="col-12 mb-3">
            <div class="card bg-light shadow-sm">
                <div class="card-body">
                    <h4 class="mb-2">Hola, <strong>{{ Auth::user()->name }}</strong> 👋</h4>
                    <p class="mb-0">
                        Has iniciado sesión como 
                        <span class="badge bg-info">{{ Auth::user()->getRoleNames()->first() ?? 'Usuario' }}</span>.
                    </p>
                </div>
            </div>
        </div>

        {{-- Sección solo para Administradores --}}
        @role('Administrador')
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ \App\Models\User::count() }}</h3>
                    <p>Usuarios Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.index') }}" class="small-box-footer">Ver usuarios <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 mb-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \Spatie\Permission\Models\Role::count() }}</h3>
                    <p>Roles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <a href="{{ route('role.index') }}" class="small-box-footer">Ver roles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 mb-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \Spatie\Permission\Models\Permission::count() }}</h3>
                    <p>Permisos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-key"></i>
                </div>
                <a href="{{ route('permissions.index') }}" class="small-box-footer">Ver permisos <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        @endrole

        {{-- Sección para Profesor --}}
        @role('Profesor')
        <div class="col-lg-6 col-md-12 mb-3">
            <div class="card border-info shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-chalkboard-teacher"></i> Panel del Profesor
                </div>
                <div class="card-body">
                    <p><strong>Acceso a clases, calificaciones y alumnos.</strong></p>
                    <div class="list-group">
                        <a href="{{ route_exists('asignaturas.index') ? route('asignaturas.index') : '#' }}" 
                        class="list-group-item list-group-item-action {{ route_exists('asignaturas.index') ? '' : 'disabled' }}" 
                        @if(!route_exists('asignaturas.index')) data-toggle="tooltip" title="En desarrollo" style="pointer-events: none; cursor: default;" @endif>
                        📚 Ver asignaturas
                        </a>
                        <a href="{{ route_exists('horarios.index') ? route('horarios.index') : '#' }}" 
                        class="list-group-item list-group-item-action {{ route_exists('horarios.index') ? '' : 'disabled' }}" 
                        @if(!route_exists('horarios.index')) data-toggle="tooltip" title="En desarrollo" style="pointer-events: none; cursor: default;" @endif>
                        🕒 Ver horarios
                        </a>
                        <a href="{{ route_exists('notas.index') ? route('notas.index') : '#' }}" 
                        class="list-group-item list-group-item-action {{ route_exists('notas.index') ? '' : 'disabled' }}" 
                        @if(!route_exists('notas.index')) data-toggle="tooltip" title="En desarrollo" style="pointer-events: none; cursor: default;" @endif>
                        📝 Consultar y gestionar notas
                        </a>
                        <a href="{{ route_exists('notas.create') ? route('notas.create') : '#' }}" 
                        class="list-group-item list-group-item-action {{ route_exists('notas.create') ? '' : 'disabled' }}" 
                        @if(!route_exists('notas.create')) data-toggle="tooltip" title="En desarrollo" style="pointer-events: none; cursor: default;" @endif>
                        ✏️ Añadir nota
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endrole

        {{-- Card común --}}
        <div class="col-lg-6 col-md-12 mb-3">
            <div class="card border-secondary shadow-sm h-100">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-info-circle"></i> Información general
                </div>
                <div class="card-body">
                    <p>Usa el menú lateral para acceder a las funciones disponibles.</p>
                    <p>Si necesitas soporte, contacta con el administrador.</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Puedes agregar estilos personalizados si los necesitas --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/main.min.css" rel="stylesheet" />
@stop

@section('js')
    {{-- Incluye FullCalendar y moment.js (si usas versiones que lo requieren) --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/locales/es.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',            // Idioma español
                firstDay: 1,             // Semana empieza en lunes
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                navLinks: true,
                editable: false,
                selectable: false,
                events: [
                    // Aquí puedes cargar eventos dinámicos o estáticos
                ]
            });
            calendar.render();
        });
    </script>
    <script>
        console.log("Dashboard visual cargado con AdminLTE.");
    </script>
@stop
