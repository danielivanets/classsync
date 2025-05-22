{{-- resources/views/home.blade.php --}}
@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1 class="text-primary">Bienvenido al Panel</h1>
@stop

@section('content')
    <div class="row">
        {{-- Card de bienvenida --}}
        <div class="col-md-12">
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
        <div class="col-md-4">
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

        <div class="col-md-4">
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

        <div class="col-md-4">
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
        <div class="col-md-6">
            <div class="card border-info shadow-sm">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-chalkboard-teacher"></i> Panel del Profesor
                </div>
                <div class="card-body">
                    <p><strong>Acceso a clases, calificaciones y alumnos.</strong></p>
                    <ul>
                        <li>📚 Ver clases asignadas</li>
                        <li>📝 Subir calificaciones</li>
                        <li>📩 Enviar mensajes</li>
                    </ul>
                </div>
            </div>
        </div>
        @endrole

        {{-- Card común --}}
        <div class="col-md-6">
            <div class="card border-secondary shadow-sm">
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
@stop

@section('js')
    <script>
        console.log("Dashboard visual cargado con AdminLTE.");
    </script>
@stop
