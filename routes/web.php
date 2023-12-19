<?php

use App\Http\Controllers\LoginController;
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
    return view('welcome');
});
Route::get('/signin', function () {
    return view('admin.signin');
})->name('signin');
Route::get('/forgotpassword', function () {
    return view('admin.forgot_pass');
});


Route::post('login', [LoginController::class, 'login'])->name('website.login');


Route::middleware(['admin_middleware'])->group(function () {
    Route::get('/admindashboard', function () {
        return view('admin.admin_dashboard');
    })->name("admin.dashboard");

    Route::get('/createuser', function () {
        return view('admin.create_user');
    })->name('createuser');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/viewuser', function () {
        return view('admin.view_user');
    });
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});



