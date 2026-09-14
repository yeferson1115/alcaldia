<?php

use App\Http\Controllers\CardsEmpleoyesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EmpleoyesController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AttendanceReportController;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('permission', PermissionController::class);
    Route::get('/roles/{roleId}/permissions/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/roles/{roleId}/permissions', [PermissionController::class, 'update'])->name('permissions.update');
    Route::resource('areas', AreasController::class);  
    Route::get('areaslist', [AreasController::class, 'getAreas'])->name('areaslist');    
    Route::resource('empleados', EmpleoyesController::class);  
    Route::get('empleoyeslist', [EmpleoyesController::class, 'getEmpleoyes'])->name('empleoyeslist');   
    Route::post('/empleoyes/update/{id}', [EmpleoyesController::class, 'update'])->name('empleoyes.update'); 
    Route::get('importempleoyes', [EmpleoyesController::class, 'import'])->name('importempleoyes');
    Route::post('importstudientssave', [EmpleoyesController::class, 'importdata'])->name('importstudientssave');
    Route::resource('carnets-empleados',   CardsEmpleoyesController::class);
    Route::resource('scanner-entradas-salidas',   ScannerController::class);
    Route::resource('reportes',   ReportController::class);
    Route::get('reportempleoyeslist', [ReportController::class, 'getEmpleoyes'])->name('reportempleoyeslist'); 
    Route::get('reportes-asistencia', [ReportController::class, 'asistencia'])->name('reportes-asistencia');
    Route::get('reportasistenciaempleoyeslist', [ReportController::class, 'getEmpleoyesAsistencia'])->name('reportasistenciaempleoyeslist'); 
    
    
    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::get('ausentismo', [AttendanceReportController::class, 'index'])->name('reports.ausentismo');
    Route::get('ausentismo/data', [AttendanceReportController::class, 'data'])->name('reports.ausentismo.data');
    Route::get('ausentismo/export', [AttendanceReportController::class, 'export'])->name('reports.ausentismo.export');
   
});



Route::get('/chat', [ChatController::class, 'index']);

Route::post('/chat/start', [ChatController::class, 'startChat']);  // Iniciar chat
Route::post('/chat/send', [ChatController::class, 'sendMessage']);  // Enviar mensaje
Route::get('/chat/{chat_id}/messages', [ChatController::class, 'getMessages']);  // Obtener mensajes
Route::get('/chat/pending', [ChatController::class, 'getPendingChats']);  // Obtener chats pendientes
Route::post('/chat/attend/{chatId}', [ChatController::class, 'attendChat']);  // Marcar chat como atendido


Route::middleware('auth')->group(function () {
    Route::get('/admin/chats', [ChatController::class, 'adminView']);
    Route::get('/chat/active', [ChatController::class, 'getActiveChats']);
});

/**Borrar cache */
Route::get('/clear-cache', function () {
    echo Artisan::call('config:clear');
    echo Artisan::call('config:cache');
    echo Artisan::call('cache:clear');
    echo Artisan::call('route:clear');
  });

require __DIR__.'/auth.php';
