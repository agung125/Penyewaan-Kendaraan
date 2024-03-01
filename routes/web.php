<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'ShowLoginForm']);

Auth::routes(['register' => false]);

Route::prefix('admin')->group(function () {

    Route::group(['middleware' => 'auth'], function(){

        //dashboard
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard.index');

        //export
        Route::get('/export/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'exportPemesanan'])->name('admin.pemesanan.export');


        //lihat pemesanan
        Route::get('/show/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'show'])->name('admin.pemesanan.show');

        //aprove reject supir
        Route::post('/supir/approve/{id}', [App\Http\Controllers\Admin\SupirController::class, 'approvePemesanan'])->name('admin.aprove.supir');
        Route::post('/supir/reject/{id}', [App\Http\Controllers\Admin\SupirController::class, 'rejectPemesanan'])->name('admin.reject.supir');

        //aprove reject pengelola
        Route::post('/pengelola/approve/{id}', [App\Http\Controllers\Admin\PengelolaController::class, 'approvePemesanan'])->name('admin.aprove.pengelola');
        Route::post('/pengelola/reject/{id}', [App\Http\Controllers\Admin\PengelolaController::class, 'rejectPemesanan'])->name('admin.reject.pengelola');


        //permissions
        Route::resource('/permission', App\Http\Controllers\Admin\PermissionController::class, ['except' => ['show', 'create', 'edit', 'update', 'delete'] ,'as' => 'admin']);

        //roles
        Route::resource('/role', App\Http\Controllers\Admin\RoleController::class, ['except' => ['show'] ,'as' => 'admin']);

        //users
        Route::resource('/user', App\Http\Controllers\Admin\UserController::class, ['except' => ['show'] ,'as' => 'admin']);

        //pemesanan
        Route::resource('/pemesanan', App\Http\Controllers\Admin\PemesananController::class, ['except' => 'show' ,'as' => 'admin']);
        //kendaraan
        Route::resource('/kendaraan', App\Http\Controllers\Admin\KendaraanController::class, ['except' => 'show' ,'as' => 'admin']);
        //supir
        Route::resource('/supir', App\Http\Controllers\Admin\SupirController::class, ['except' => 'show' ,'as' => 'admin']);
        //pengelola
        Route::resource('/pengelola', App\Http\Controllers\Admin\PengelolaController::class, ['except' => 'show' ,'as' => 'admin']);



    });

});
