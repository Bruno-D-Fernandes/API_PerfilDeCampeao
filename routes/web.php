<?php

use App\Events\UserFollowedEvent;
use App\Events\ClubFollowedEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\OportunidadeController;
use App\Models\Clube;
use App\Models\Usuario;
use App\Notifications\UserFollowedNotification;
use Illuminate\Notifications\Notification;

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

Route::get('/perfil1', function () {
    return view('perfil');
})->name('perfil');

Route::get('/login', function () {
    return view('login'); 
})->name('login');

Route::get('/admin', function () {
    return view('loginAdmin'); 
})->name('loginAdmin');

Route::get('/perfilAdmin', function () {
    return view('perfilAdmin'); 
})->name('perfilAdmin');

Route::get('/registro', function () {
    return view('register');
})->name('registro');

/*Novas Club*/
Route::get('/', function () {
    return route('login');
});

Route::get('/cadastro', function () {
    return view('cadastro');
})->name('Cadastro');

Route::get('/lista', function () {
    return view('listaClub');
})->name('Lista');

Route::get('/pesquisa', function () {
    return view('pesquisaClub');
})->name('Pesquisa');

Route::get('/perfil', function () {
    return view('perfilClub');
})->name('Perfil');

Route::get('/oportunidades', function () {
    return view('oportunidadesClub');
})->name('Oportunidades');

Route::get('/configuracoes', function () {
    return view('configuraçoesClub');
})->name('Configurações');

Route::get('/dashClub', function () {
    return view('dashClub');
})->name('Dash Do Club');

// essas rotas não deveriam estar na api.php ? --Bruno

//arrumando as rotas ainda
Route::delete('/api/conta/delete', [ContaController::class, 'destroyAccount'])->name('conta.delete');

Route::put('/api/conta/update-email', [ContaController::class, 'updateEmail'])->name('conta.update.email');
Route::put('/api/conta/update-password', [ContaController::class, 'updatePassword'])->name('conta.update.password');

    // Rotas do ClubeController
Route::put('/clube/update-info', [ClubeController::class, 'updateInfo'])->name('clube.updateInfo');
Route::put('/clube/update-password', [ClubeController::class, 'updatePassword'])->name('clube.updatePassword');






//Novas Rotas ADM

Route::get('/usuarios', function () {
    return view('usuarios');
})->name('usuarios');

Route::get('/esporte', function () {
    return view('esportes');
})->name('Lista Esportes');

Route::get('/dashAdm', function () {
    return view('dashAdm');
})->name('Dashbord Adm');

Route::get('/oportunidadesAdm', function () {
    return view('oportunidadesAdm');
})->name('oportunidades Adm');
    
Route::get('/test-notif', function () {
    $follower = Usuario::find(1);
    $clubeFollowed = Clube::find(1);
    event(new ClubFollowedEvent($follower, $clubeFollowed));
});

Route::get('/test', function () {
    return view('test');
});
