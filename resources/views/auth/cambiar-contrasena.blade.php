@extends('adminlte::page')

@section('title', 'Cambiar Contraseña')

@section('content_header')
    <h1 class="text-primary">Actualiza tu Contraseña</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card bg-light shadow-sm">
            <div class="card-body">
                <h4 class="mb-3">Hola, <strong>{{ Auth::user()->name }}</strong> 👋</h4>
                <p class="text-muted">
                    Por motivos de seguridad, necesitas establecer una nueva contraseña antes de continuar utilizando el sistema.
                    Esta acción solo se solicitará una vez.
                </p>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success mt-3">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <strong>¡Ups!</strong> Hubo algunos errores con tu ingreso:<br><br>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card card-primary mt-4">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-lock"></i> Cambiar Contraseña</h3>
            </div>
            <form method="POST" action="{{ route('password.change') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="password">Nueva contraseña <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Introduce una contraseña segura" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar contraseña <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Repite la contraseña" required>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle"></i> Guardar y continuar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(session('status'))
        toastr.success("{{ session('status') }}");
    @endif
</script>
@stop
