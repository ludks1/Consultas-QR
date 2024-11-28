<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Models\Subject;
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

// Vistas predetermiandas
Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/subject_admin', [SubjectController::class, 'showSubjectForm'])->name('subject');
Route::post('/create-subject', [SubjectController::class, 'store'])->name('subject.store');

// Rutas de horarios
Route::get('/schedule_admin', [ScheduleController::class, 'showScheduleForm'])->name('schedule');
Route::post('/create-schedule', [ScheduleController::class, 'store'])->name('schedule.store');

// Rutas para obtener edificios y lugares con AJAX
Route::get('/get-buildings/{institutionId}', [ScheduleController::class, 'getBuildings']);
Route::get('/get-spaces/{spaceId}', [ScheduleController::class, 'getSpaces']);

// Rutas de búsqueda
Route::get('/search', function () {
    return view('search');
})->name('search');

// Rutas de registro
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('users.store');

// Rutas de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de maestro
Route::get('/teachers_admin', function () {
    return view('teacher');
})->name('teacher');

// Rutas de estudiantes
Route::get('/students_admin', function () {
    return view('student');
})->name('student');

// Rutas para crear espacios
Route::get('/space_admin', [SpaceController::class, 'showSpaceForm'])->name('space');
Route::post('/create-space', [SpaceController::class, 'store'])->name('space.store');

// Rutas para obtener edificios y pisos con AJAX
Route::get('/get-buildings/{institutionId}', [SpaceController::class, 'getBuildings']);
Route::get('/get-floors/{buildingId}', [SpaceController::class, 'getFloors']);

// Rutas para crear edificios
Route::get('/building_admin', [BuildingController::class, 'showBuildingForm'])->name('building');
Route::post('/create-building', [BuildingController::class, 'store'])->name('building.store');

// Rutas para crear instituciones
Route::get('/institutions_admin', [InstitutionController::class, 'showInstitutionForm'])->name('institution');
Route::post('/create-institution', [InstitutionController::class, 'store'])->name('institution.store');
