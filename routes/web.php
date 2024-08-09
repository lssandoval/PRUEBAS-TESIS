<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BienesController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\GenerarListaQRController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProgramacionMantenimientosController;
use App\Http\Controllers\AsistenciasTecnologicassController;
use App\Http\Controllers\SSOController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificacionesController;
use Laravel\Fortify\Features;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Log;

// routes/web.php



Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta para inicio de sesión SSO
Route::get('/sso-login', [SSOController::class, 'login'])->name('sso.login');

// Rutas protegidas por autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::middleware('check.sso')->group(function () {
    });
    Route::get('dashboard', [Dashboard::class, 'index'])->name('dashboard');

    Route::get('/no-access', function () {
        return redirect()->route('dashboard');
    })->name('no-access');
    Route::get('/refresh-captcha', [LoginController::class, 'refreshCaptcha'])->name('refresh-captcha');


    // Rutas relacionadas con los bienes
    Route::get('/bienes', [BienesController::class, 'index'])->name('bienes-tecnologicos');
    Route::get('datatable/bienes', [BienesController::class, 'bienes'])->name('datatable.bienes');
    Route::get('/editar-bien/{id}', [BienesController::class, 'editarBien'])->name('editar-bien');
    Route::delete('/eliminar-bien', [BienesController::class, 'eliminar'])->name('eliminar-bien');
    Route::put('/actualizar-bien/{id}', [BienesController::class, 'actualizarBien'])->name('actualizar-bien');

    // Rutas relacionadas con archivos
    Route::post('/subir-archivo', [ArchivoController::class, 'subirArchivo'])->name('subirArchivo');
    Route::post('/subir-componentes', [ArchivoController::class, 'subirArchivoComponentes'])->name('subirArchivoComponentes');
    Route::get('/historial-carga', [ArchivoController::class, 'historialCarga'])->name('historial-carga');

    // Ruta para generar código QR
    Route::post('/generate-qrcode', [QRCodeController::class, 'generateQR'])->name('generate-qrcode');

    // Ruta para generar lista de QRs
    Route::post('/generar-qrs', [GenerarListaQRController::class, 'generateQRCodes'])->name('generar.qrs');
    Route::get('/bienesl', [GenerarListaQRController::class, 'index'])->name('bienes.index');
    Route::get('/generar-pdf', [GenerarListaQRController::class, 'generatePDF'])->name('generar.pdf');

    // Rutas Mantenimientos
    Route::get('/mantenimientos/{id}', [MantenimientoController::class, 'mostrarMantenimientos'])->name('mostrarMantenimientos.mostrar');
    Route::post('/mantenimientos/guardar', [MantenimientoController::class, 'guardarMantenimiento'])->name('guardar-mantenimiento');

    Route::get('/programacion_mantenimientos', [ProgramacionMantenimientosController::class, 'index'])->name('programacion-mantenimientos');

    // Ruta de Asignación de Roles
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/roles/data', [RolesController::class, 'data'])->name('roles.data');
    Route::post('/roles/update/{nombre_apellido}', [RolesController::class, 'updateRoles']);
    Route::post('/roles/remove/{username}', [RolesController::class, 'removeRoles']);



    // Generar PDF
    Route::get('/generar-pdfReporte', [PdfController::class, 'generarpdfReporte'])->name('generar.pdfReporte');

    Route::get('personas', [PersonaController::class, 'index']);

    // Ruta Asistencias Tecnológicas
    Route::get('/asistencias-tecnologicas', [AsistenciasTecnologicassController::class, 'index'])->name('asistencias_tecnologicas');
    Route::post('/asistencias', [AsistenciasTecnologicassController::class, 'store'])->name('asistencias.store');
    Route::post('/asistencias/storeSolution', [AsistenciasTecnologicassController::class, 'storeSolution'])->name('asistencias.storeSolution');


    //Notificaciones
    Route::get('/notificaciones', [NotificacionesController::class, 'index'])->name('notificaciones');
});
