<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/about', function () {
    return view('about');
})->name('about');

// rutas de horarios
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
Route::get('/schedule', function () {
    return view('schedule');
})->name('schedule');

Route::get('/search', function () {
    return view('search');
})->name('search');

// rutas de registro
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');

Route::post('/register', [UserController::class, 'store'])->name('users.store');

//rutas de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// rutas de navbar para administrador
Route::get('/teachers_admin', function () {
    return view('teacher');
})->name('teacher');

Route::get('/students_admin', function () {
    return view('student');
})->name('student');


Route::get('/spaces_admin', function () {
    return view('space');
})->name('space');

Route::get('/building', [BuildingController::class, 'showBuildingForm'])->name('building');

Route::post('/create-building', [BuildingController::class, 'store'])->name('building.store');

Route::get('/institutions_admin', [InstitutionController::class, 'showInstitutionForm'])->name('institution');

Route::post('/create-institution', [InstitutionController::class, 'store'])->name('institution.store');
