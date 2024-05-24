<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TodoController;
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

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', [AdminController::class, 'register'])->name('register');
Route::post('/register', [AdminController::class, 'doregister'])->name('doregister');

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/do-login', [AdminController::class, 'doLogin'])->name('doLogin');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');


Route::middleware(['adminauth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::post('/todo-store', [TodoController::class, 'store'])->name('todo.store');
    Route::delete('todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
    Route::get('/todo/{id}/edit', [TodoController::class, 'edit'])->name('todo.edit');
    Route::put('/todos/{id}', [TodoController::class, 'update'])->name('todo.update');

    Route::get('/todo-getdata', [TodoController::class, 'getData'])->name('todo.getData');
});
