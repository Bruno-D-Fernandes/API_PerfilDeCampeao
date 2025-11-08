<?php

use App\Events\ClubFollowedEvent;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\ClubeController;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
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

Route::get('/clube/cadastro', function () {
    return view('clube.cadastro')->with(['categorias' => Categoria::all(), 'esportes' => Esporte::all()]);
})->name('clube-cadastro');

Route::get('/clubes/{id}', [ClubeController::class, 'showProfilePage'])->name('clube-perfil');

Route::get('/admin/esportes', [AdmController::class, 'ListarEsportesWeb'])->name('admin-esportes');

Route::get('/admin/funcoes', [FuncaoController::class, 'showWebPage'])->name('admin-funcoes');

Route::get('/admin/clubes', [ClubeController::class, 'showWebPage'])->name('admin-clubes');

Route::get('/admin/usuarios', [UserController::class, 'showWebPage'])->name('admin-usuarios');

Route::get('/admin/oportunidades', [OportunidadeController::class, 'showWebPage'])->name('admin-oportunidades');

Route::get('/admin/perfil', [AdmController::class, 'showProfilePage']);