@extends('adminlte::page')

@section('title', 'Editar Perfil')

@section('content_header')
    <h1 class="mb-3">Editar Perfil</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <form action="{{ route('profile.update', $user->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-user-edit mr-2"></i>Actualizar Información</h3>
                </div>

                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label"><i class="fas fa-user mr-1 text-primary"></i> Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="form-label"><i class="fas fa-envelope mr-1 text-primary"></i> Correo Electrónico</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label"><i class="fas fa-lock mr-1 text-primary"></i> Nueva Contraseña <small class="text-muted">(opcional)</small></label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            autocomplete="new-password"
                            placeholder="******"
                        >
                        <small id="passwordHelp" class="text-danger d-none">La contraseña debe tener al menos 8 caracteres.</small>
                        @error('password')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label"><i class="fas fa-lock mr-1 text-primary"></i> Confirmar Contraseña</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="form-control @error('password_confirmation') is-invalid @enderror" 
                            autocomplete="new-password"
                            placeholder="******"
                        >
                        <small id="confirmHelp" class="text-danger d-none">Las contraseñas no coinciden.</small>
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between align-items-center">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
    .form-label {
        font-weight: 600;
    }
    .form-control::placeholder {
        color: #aaa;
        font-style: italic;
    }
</style>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const passwordHelp = document.getElementById('passwordHelp');
    const confirmHelp = document.getElementById('confirmHelp');
    const form = document.querySelector('form');

    function validatePassword() {
        if (password.value.length > 0 && password.value.length < 8) {
            passwordHelp.classList.remove('d-none');
            password.classList.add('is-invalid');
            return false;
        } else {
            passwordHelp.classList.add('d-none');
            password.classList.remove('is-invalid');
            return true;
        }
    }

    function validateConfirm() {
        if (password.value != confirm.value) {
            confirmHelp.classList.remove('d-none');
            confirm.classList.add('is-invalid');
            return false;
        } else {
            confirmHelp.classList.add('d-none');
            confirm.classList.remove('is-invalid');
            return true;
        }
    }

    password.addEventListener('input', () => {
        validatePassword();
        if (confirm.value.length > 0) validateConfirm();
    });

    confirm.addEventListener('input', () => {
        validateConfirm();
    });

    form.addEventListener('submit', function (e) {
        // Solo validamos si el campo contraseña tiene algo
        if (password.value.length > 0) {
            const passValid = validatePassword();
            const confirmValid = validateConfirm();

            if (!passValid || !confirmValid) {
                e.preventDefault();
            }
        }
    });
});
</script>
@stop
