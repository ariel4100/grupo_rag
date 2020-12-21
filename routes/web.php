<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//})->name('home');
Route::middleware(['auth:sanctum', 'verified'])->get('/adm', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');
Route::get('config', function () {
    \Artisan::call('config:clear');
    dd("config is cleared");
});
Route::get('cache', function () {
    \Artisan::call('optimize');
    dd("Cache is cleared");
});
Route::get('link', function () {
    $exitCode = \Artisan::call('storage:link', []);
    echo $exitCode; // 0 exit code for no errors.
});

//Secciones
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('empresa', [FrontendController::class, 'empresa'])->name('empresa');
Route::get('clientes', [FrontendController::class, 'clientes'])->name('clientes');
Route::get('calidad', [FrontendController::class, 'calidad'])->name('calidad');
Route::get('laboratorio', [FrontendController::class, 'laboratorio'])->name('laboratorio');
Route::get('buscador', [FrontendController::class, 'buscador'])->name('buscador');
Route::get('contacto', [FrontendController::class, 'contacto'])->name('contacto');
Route::post('contacto', [MailController::class, 'contacto'])->name('mail.contacto');
Route::get('presupuesto', [FrontendController::class, 'presupuesto'])->name('presupuesto');
Route::post('presupuesto', [MailController::class, 'presupuesto'])->name('mail.presupuesto');

//productos
Route::get('productos', [FrontendController::class, 'familias'])->name('familias');
Route::get('productos/{slug}', [FrontendController::class, 'productos'])->name('productos');
Route::get('producto/{slug}', [FrontendController::class, 'producto'])->name('producto');

//Vistas que no requieren controladores
Route::get('presupuesto', function () {
    return Inertia\Inertia::render('Web/Presupuesto');
})->name('presupuesto');