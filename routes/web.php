<?php

use App\Http\Controllers\BelajarController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RealtimeController;
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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/locale/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('locale');

Route::get('/enkripsi', [BelajarController::class, 'enkripsi'])->name('enkripsi');
Route::get('/cache', [BelajarController::class, 'cache'])->name('cache');
Route::get('/enkripsi_detail/{params}', [BelajarController::class, 'enkripsi_detail'])->name('enkripsi-detail');

Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::post('/forgot-password-proses', [LoginController::class, 'forgot_password_proses'])->name('forgot-password-proses');

Route::get('/forgot-password-validate/{token}', [LoginController::class, 'forgot_password_validate'])->name('forgot-password-validate');
Route::post('/forgot-password-validate/{token}', [LoginController::class, 'forgot_password_validate_process'])->name('forgot-password-validate-process');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('/register-proses', [LoginController::class, 'register_proses'])->name('register-proses');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
    // cek yang punya middleware view dashboard
    // Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard')->middleware('can:view_dashboard');

    Route::get('/user/clientside', [DataTableController::class, 'clientside'])->name('user.clientside');

    Route::get('/user/import', [HomeController::class, 'import'])->name('user.import');
    Route::post('/user/import-proses', [HomeController::class, 'import_proses'])->name('user.import_proses');
    Route::get('/assets', [HomeController::class, 'assets'])->name('assets.index');
    Route::get('/user', [HomeController::class, 'index'])->name('user.index');
    Route::get('/create', [HomeController::class, 'create'])->name('user.create');
    Route::post('/store', [HomeController::class, 'store'])->name('user.store');
    Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('user.detail');
    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('user.edit');
    Route::put('/update/{id}', [HomeController::class, 'update'])->name('user.update');
    Route::delete('/delete/{id}', [HomeController::class, 'delete'])->name('user.delete');

    Route::group(['prefix' => 'realtime', 'as' => 'realtime.'], function () {
        Route::get('/chat1', [RealtimeController::class, 'chat1'])->name('chat1');
        Route::get('/chat2', [RealtimeController::class, 'chat2'])->name('chat2');
        Route::post('/send-message', [RealtimeController::class, 'sendMessage'])->name('send-message');
    });
});
