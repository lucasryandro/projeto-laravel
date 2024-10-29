<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HevyController;


Route::get('/', function () { return view('index');})->name('Home');


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('/registerUser', [AuthController::class, 'register'])->name('userRegister');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post("/loginUser", [AuthController::class, 'autenticateUser'])->name('autenticateUser');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

Route::get('/hevyApi', [HevyController::class, 'getWorkout'])->name('hevy_api');

Route::middleware('auth')->group(function () {
Route::get('/Admin', [UserController::class, 'pageRender'])->name('users.pageRender');
Route::post('/Logout', [AuthController::class, 'logoutUser'])->name('logoutUser');

Route::get('/users/edit/{id}', [UserController::class, 'updateView'])->name('user.updateView');
Route::get('/user/edit/', [UserController::class, 'update'])->name('user.update');

Route::post('/users/delete', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/showWorkouts', [HevyController::class, 'showWorkouts'])->name('Workouts');



});
