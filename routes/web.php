<?php

use App\Events\UserFollowedEvent;
use App\Events\ClubFollowedEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebController;
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

Route::get('/perfil', function () {
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

Route::get('/cadastro', function () {
    return view('cadastro');
})->name('Cadastro');

Route::get('/lista', function () {
    return view('listaClub');
})->name('Lista');

Route::get('/pesquisa', function () {
    return view('pesquisaClub');
})->name('Pesquisa');



Route::get('/test-notif', function () {
    $follower = Usuario::find(1);
    $clubeFollowed = Clube::find(1);
    event(new ClubFollowedEvent($follower, $clubeFollowed));
});

Route::get('/test', function () {
    return view('test');
});
