<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DescargaController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\MetaController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubfamilyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\FrontendController;
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

Route::get('/contenido/{section}', [ContentController::class, 'index'])->name('content.index');
Route::get('/panel-datos', [ContentController::class, 'panel'])->name('content.panel');
Route::post('/contenido-save', [ContentController::class, 'store'])->name('content.store');
Route::post('/contenido-slider', [ContentController::class, 'slider'])->name('content.slider');
Route::get('/destroy/slider/{id}', [ContentController::class, 'destroy_slider'])->name('content.destroy.slider');
Route::post('/contenido-logo', [ContentController::class, 'logos'])->name('content.logo');
Route::get('/block-destroy/{id}', [ContentController::class, 'destroy_block'])->name('content.destroy.block');
Route::resource('productos', ProductController::class);
Route::resource('usuarios', UserController::class);
Route::resource('familias', FamilyController::class);
Route::resource('metas', MetaController::class);
//Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');

//Route::prefix('admin')->middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia\Inertia::render('Dashboard');
//})->name('dashboard');
