@extends('adminlte::page')

@section('title', 'Editar Permiso')

@section('content_header')
    <h1>Editar Permiso</h1>
@stop

@section('content')
    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre del Permiso</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
        </div>

        <div class="form-group">
            <label for="guard_name">Guard</label>
            <input type="text" name="guard_name" id="guard_name" class="form-control" value="{{ old('guard_name', $permission->guard_name) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@stop
