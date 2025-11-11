<?php

use App\Events\ClubFollowedEvent;
use Illuminate\Support\Facades\Route;
use App\Mail\ClubWelcomeEmail;
use App\Mail\UserWelcomeEmail;
use App\Models\Clube;
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

Route::get('/clube/login', function () {
    return view('clube.login');
})->name('clube.login');


Route::get('/admin/login', function () {
    return view('admin.login');
}) ->name('admin.login');

Route::get('/clube/oportunidades',function(){
    return view('clube.oportunidades');
})->name('clube.oportunidades');

Route::get('/admin/oportunidades',function(){
    return view('admin.oportunidades');
})->name('admin.oportunidades');

Route::get('/admin/dashboard',function(){
    return view('admin.Dashboard');
})->name('admin.Dashboard');

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

Route::get('/clube/dashboard',function(){
    return view('clube.Dashboard');
})->name('clube.Dashboard');

Route::get('/clube/configuracao',function(){
    return view('clube.configuracao');
})->name('clube.configuracao');

