<?php

use App\Events\ClubFollowedEvent;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\ClubeController;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\ListaClubeController;
use Illuminate\Support\Facades\Route;
use App\Mail\ClubWelcomeEmail;
use App\Mail\UserWelcomeEmail;
use App\Models\Categoria;
use App\Models\Clube;
use App\Models\Esporte;
use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;

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

// routes/web.php
// Clube 
Route::get('/clube/cadastro', function () {
    return view('clube.cadastro')->with(['categorias' => Categoria::all(), 'esportes' => Esporte::all()]);
})->name('clube-cadastro');

Route::get('/clube/oportunidades',function(){
    return view('clube.oportunidades');
})->name('clube.oportunidades');

Route::get('/clubes/{id}', [ClubeController::class, 'showProfilePage'])->name('clube-perfil');

Route::get('/clube/configuracao',function(){
    return view('clube.configuracao');
})->name('clube.configuracao');

Route::get('/clube/login', function () {
    return view('clube.login');
})->name('clube.login');

// Admin

Route::get('/admin/login', function () {
    return view('admin.login');
}) ->name('admin.login');

Route::get('/admin/esportes', [AdmController::class, 'ListarEsportesWeb'])->name('admin-esportes');

Route::get('/admin/funcoes', [FuncaoController::class, 'showWebPage'])->name('admin-funcoes');

Route::get('/admin/clubes', [ClubeController::class, 'showWebPage'])->name('admin-clubes');

Route::get('/admin/usuarios', [UserController::class, 'showWebPage'])->name('admin-usuarios');

Route::get('/admin/perfil', [AdmController::class, 'showProfilePage']);

Route::get('/admin/oportunidades', [OportunidadeController::class, 'showWebPage'])->name('admin-oportunidades');

Route::get('/admin/listas', [ListaClubeController::class, 'showWebPage'])->name('admin-listas');

Route::get('/admin/perfil', [AdmController::class, 'showProfilePage']);

Route::get('/admin/config/perfil',function(){
    return view('admin.config.perfil');
})->name('admin.config.perfil');

Route::get('/admin/config/layout',function(){
    return view('admin.config.layout');
})->name('admin.config.layout');

Route::get('/admin/config/backup',function(){
    return view('admin.config.backup');
})->name('admin.config.backup');

Route::get('/admin/config/notificacoes',function(){
    return view('admin.config.notificacoes');
})->name('admin.config.notificacoes');

Route::get('/admin/config/sobre',function(){
    return view('admin.config.sobre');
})->name('admin.config.sobre');

Route::get('/admin/config/tema',function(){
    return view('admin.config.tema');
})->name('admin.config.tema');