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