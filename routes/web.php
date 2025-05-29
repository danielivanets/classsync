<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NotaDeClaseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PasswordChangeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

//Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::middleware('auth')->group(function () {
    //CRUD Usuarios
    Route::resource('admin', AdminController::class)->names('admin');
    Route::post('/admin/{id}/toggle-visible', [AdminController::class, 'toggleVisible'])->name('admin.toggleVisible');
    Route::get('/profesores', [AdminController::class, 'profesores'])->name('profesores.index');
    //CRUD Roles
    Route::resource('role', RoleController::class)->names('role'); //roles y permisos
    // Perfil de usuario
    Route::resource('profile', ProfileController::class)->names('profile');
    //CRUD Aulas
    Route::resource('aulas', AulaController::class)->names('aulas');
    Route::post('/aulas/{id}/toggle-visible', [AulaController::class, 'toggleVisible'])->name('aulas.toggleVisible');

    //CRUD Departamentos
    Route::resource('departamentos', DepartamentoController::class)->names('departamentos');
    //CRUD Asignaturas
    Route::resource('asignaturas', AsignaturaController::class)->names('asignaturas');
    Route::post('/asignaturas/{id}/toggle-visible', [AsignaturaController::class, 'toggleVisible'])->name('asignaturas.toggleVisible');
    //CRUD Horarios
    Route::resource('horarios', HorarioController::class)->names('horarios');
    Route::post('/horarios/{horario}/toggle-visible', [HorarioController::class, 'toggleVisible'])->name('horarios.toggleVisible');
    //CRUD NotaDeClase
    Route::resource('notas', NotaDeClaseController::class);
    Route::post('notas/{nota}/toggle-visible', [NotaDeClaseController::class, 'toggleVisible'])->name('notas.toggle-visible');

    Route::resource('permissions', PermissionController::class);



    Route::get('/cambiar-contrasena', [PasswordChangeController::class, 'showForm'])->name('password.change');
    Route::post('/cambiar-contrasena', [PasswordChangeController::class, 'update']);
    Route::get('/profesor/{id}/asignaturas', [NotaDeClaseController::class, 'getAsignaturasPorProfesor'])->name('profesor.asignaturas');


});