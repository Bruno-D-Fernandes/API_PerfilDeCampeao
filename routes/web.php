<?php

use App\Events\ClubFollowedEvent;
use App\Http\Controllers\AdmController;
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

Route::get('/clube/cadastro', function () {
    return view('clube.cadastro');
})->name('clube-cadastro');

Route::get('/admin/esportes', [AdmController::class, 'ListarEsportesWeb'])->name('admin-esportes');


