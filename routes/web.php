<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DiputadoController;
use App\Http\Controllers\LeyController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\TransparenciaController;
use App\Http\Controllers\InstitutionalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ============================================
// RUTAS PÚBLICAS
// ============================================

// Página de inicio
Route::get('/', [InstitutionalController::class, 'home'])->name('home');

// Módulo Institucional
Route::get('/institucion', [InstitutionalController::class, 'index'])->name('institucion.index');
Route::get('/institucion/{id}', [InstitutionalController::class, 'show'])->name('institucion.show');

// Módulo de Diputados
Route::get('/diputados', [DiputadoController::class, 'index'])->name('diputados.index');
Route::get('/diputados/{id}', [DiputadoController::class, 'show'])->name('diputados.show');

// Módulo Legislativo (Leyes)
Route::get('/leyes', [LeyController::class, 'index'])->name('leyes.index');
Route::get('/leyes/{id}', [LeyController::class, 'show'])->name('leyes.show');
Route::get('/leyes/{id}/download', [LeyController::class, 'download'])->name('leyes.download');

// Módulo de Noticias
Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{slug}', [NoticiaController::class, 'show'])->name('noticias.show');

// Módulo de Transparencia - Público
Route::get('/transparencia', [TransparenciaController::class, 'index'])->name('transparencia.index');
Route::get('/transparencia/{id}', [TransparenciaController::class, 'show'])->name('transparencia.show');
Route::get('/transparencia/{id}/download', [TransparenciaController::class, 'download'])->name('transparencia.download');
Route::get('/transparencia/{id}/download-excel', [TransparenciaController::class, 'downloadExcel'])->name('transparencia.download-excel');

// Atención Ciudadana (pública)
Route::get('/consulta', [ConsultaController::class, 'create'])->name('consulta.create');
Route::post('/consulta', [ConsultaController::class, 'store'])->name('consulta.store');

// Upload de imágenes para el editor
Route::post('/admin/upload-image', [NoticiaController::class, 'uploadImage'])->name('admin.upload.image')->middleware('auth');
// ============================================
// AUTENTICACIÓN
// ============================================

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// RUTAS PROTEGIDAS (Requieren autenticación)
// ============================================

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ============================================
    // ADMIN - DIPUTADOS (Admin y Editor)
    // ============================================
    // ADMIN - DIPUTADOS
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/diputados', [DiputadoController::class, 'adminIndex'])->name('diputados.index');
        Route::get('/diputados/create', [DiputadoController::class, 'create'])->name('diputados.create');
        Route::post('/diputados', [DiputadoController::class, 'store'])->name('diputados.store');
        Route::get('/diputados/{id}/edit', [DiputadoController::class, 'edit'])->name('diputados.edit');
        Route::put('/diputados/{id}', [DiputadoController::class, 'update'])->name('diputados.update');
        Route::delete('/diputados/{id}', [DiputadoController::class, 'destroy'])->name('diputados.destroy');
        Route::get('/diputados/{id}/toggle', [DiputadoController::class, 'toggleStatus'])->name('diputados.toggle');
    });

   
    // ============================================
    // ADMIN - LEYES (Admin y Editor)
    // ============================================
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/leyes', [LeyController::class, 'adminIndex'])->name('leyes.index');
        Route::get('/leyes/create', [LeyController::class, 'create'])->name('leyes.create');
        Route::post('/leyes', [LeyController::class, 'store'])->name('leyes.store');
        Route::get('/leyes/{id}/edit', [LeyController::class, 'edit'])->name('leyes.edit');
        Route::put('/leyes/{id}', [LeyController::class, 'update'])->name('leyes.update');
        Route::delete('/leyes/{id}', [LeyController::class, 'destroy'])->name('leyes.destroy');
    });

    // ============================================
    // ADMIN - NOTICIAS (Admin y Editor)
    // ============================================
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/noticias', [NoticiaController::class, 'adminIndex'])->name('noticias.index');
        Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create');
        Route::post('/noticias', [NoticiaController::class, 'store'])->name('noticias.store');
        Route::get('/noticias/{id}/edit', [NoticiaController::class, 'edit'])->name('noticias.edit');
        Route::put('/noticias/{id}', [NoticiaController::class, 'update'])->name('noticias.update');
        Route::get('/noticias/{id}/toggle', [NoticiaController::class, 'togglePublish'])->name('noticias.toggle');
        Route::delete('/noticias/{id}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');
    });
    // ============================================
    // ADMIN - NOTICIAS
    // ============================================
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/noticias', [NoticiaController::class, 'adminIndex'])->name('noticias.index');
        Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create');
        Route::post('/noticias', [NoticiaController::class, 'store'])->name('noticias.store');
        Route::get('/noticias/{id}/edit', [NoticiaController::class, 'edit'])->name('noticias.edit');
        Route::put('/noticias/{id}', [NoticiaController::class, 'update'])->name('noticias.update');
        Route::get('/noticias/{id}/toggle', [NoticiaController::class, 'togglePublish'])->name('noticias.toggle');
        Route::delete('/noticias/{id}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');
    });

    // ============================================
    // ADMIN - TRANSPARENCIA (Admin y Editor)
    // ============================================
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/transparencia', [TransparenciaController::class, 'adminIndex'])->name('transparencia.index');
        Route::get('/transparencia/create', [TransparenciaController::class, 'create'])->name('transparencia.create');
        Route::post('/transparencia', [TransparenciaController::class, 'store'])->name('transparencia.store');
        Route::get('/transparencia/{id}/edit', [TransparenciaController::class, 'edit'])->name('transparencia.edit');
        Route::put('/transparencia/{id}', [TransparenciaController::class, 'update'])->name('transparencia.update');
        Route::delete('/transparencia/{id}', [TransparenciaController::class, 'destroy'])->name('transparencia.destroy');
    });

    // ============================================
    // ADMIN - CONSULTAS (Admin y Editor)
    // ============================================
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/consultas', [ConsultaController::class, 'index'])->name('consultas.index');
        Route::get('/consultas/{id}', [ConsultaController::class, 'show'])->name('consultas.show');
        Route::post('/consultas/{id}/respond', [ConsultaController::class, 'respond'])->name('consultas.respond');
        Route::put('/consultas/{id}/status', [ConsultaController::class, 'updateStatus'])->name('consultas.status');
        Route::delete('/consultas/{id}', [ConsultaController::class, 'destroy'])->name('consultas.destroy');
    });

// ============================================
// ADMIN - USUARIOS (SOLO ADMIN)
// ============================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{id}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
});

});