<?php

use App\Events\UserFollowedEvent;
use App\Events\ClubFollowedEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebController;
use App\Mail\ClubWelcomeEmail;
use App\Mail\UserWelcomeEmail;
use App\Models\Clube;
use App\Models\Usuario;
use App\Notifications\UserFollowedNotification;
use Illuminate\Notifications\Notification;
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

Route::get('/test-notif', function () {
    $follower = Usuario::find(1);
    $clubeFollowed = Clube::find(1);
    event(new ClubFollowedEvent($follower, $clubeFollowed));
});

Route::get('/test-email', function () {
    Mail::to('norventcc@gmail.com')->send(
        new UserWelcomeEmail()
    );

    Mail::to('norventcc@gmail.com')->send(
        new ClubWelcomeEmail()
    );
});

Route::get('/test', function () {
    return view('test');
});
