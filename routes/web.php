<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\PreventivosController;
use App\Http\Controllers\PreventivosEnCursoController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\TaskController;


// Ruta para mostrar el formulario de inicio de sesión
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

// Ruta para manejar el inicio de sesión
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Ruta para el cierre de sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

    Route::get('/inicio', [HomeController::class, 'index'])->name('inicio');

    Route::get('/adminmaquinas', [MachineController::class, 'index'])->name('adminmaquinas.index');

    Route::get('/asignacion', [AsignacionController::class, 'index'])->name('asignacion.index');

    Route::get('/historial', [HistorialController::class, 'index'])->name('historial');

    Route::get('/preventivos', [PreventivosController::class, 'index'])->name('preventivos');

    Route::get('/preventivos-en-curso', [PreventivosEnCursoController::class, 'index'])->name('preventivos-en-curso');

    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
});

// Rutas para administración de máquinas
Route::post('adminmaquinas/agregar', [MachineController::class, 'store'])->name('adminmaquinas.store');
Route::delete('adminmaquinas/eliminar/{id}', [MachineController::class, 'destroy'])->name('adminmaquinas.destroy');
Route::put('adminmaquinas/update', [MachineController::class, 'update'])->name('adminmaquinas.update');

// Rutas para el controlador de usuarios
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
Route::post('/usuarios/update-status', [UserController::class, 'updateStatus'])->name('usuarios.updateStatus');

// Rutas Asignación de preventivos
Route::post('/asignacion', [AsignacionController::class, 'store'])->name('asignacion.store');

// Rutas para Preventivos en progreso
Route::get('/preventivos-en-curso', [PreventivosEnCursoController::class, 'index'])->name('preventivos-en-curso');
Route::patch('/preventivos-en-curso/{id}', [PreventivosEnCursoController::class, 'update'])->name('preventivos-en-curso.update');
Route::delete('/preventivos-en-curso/{id}', [PreventivosEnCursoController::class, 'destroy'])->name('preventivos-en-curso.destroy');

// Rutas historial
Route::get('/historial', [HistorialController::class, 'index'])->name('historial');
Route::delete('/tasks/{id}', [HistorialController::class, 'destroy'])->name('tasks.destroy');

// Ruta para mostrar los detalles de la tarea
Route::get('task/{id}', [TaskController::class, 'show'])->name('task');
Route::post('/task/{id}/complete', [TaskController::class, 'complete'])->name('task.complete');
