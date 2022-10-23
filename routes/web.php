<?php

use App\Models\Company;
use Services\Helpers\TimeHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AppointmentController;

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

Route::get('/', function () {
    return view('welcome');
});

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::group([
    'prefix' => 'admin', 
    'as' => 'admin.', 
    'middleware' => ['auth', 'verified']
], function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::prefix('/customers')->group(function(){
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/new', [CustomerController::class, 'create'])->name('customer.create');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('customer.show');
    });

    Route::prefix('/representatives')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
    });

    Route::prefix('/company')->group(function(){
        Route::get('/', [CompanyController::class, 'index'])->name('company.index');
        Route::get('/{company}', [CompanyController::class, 'show'])->name('company.show');
    });

    
    Route::prefix('/appointments')->group(function(){
        Route::get('/', [AppointmentController::class, 'index'])->name('appointment.index');
        Route::get('/new', [AppointmentController::class, 'create'])->name('appointment.create');
        Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('appointment.show');
    });
});

Route::get('/calendar', [AppointmentController::class, 'customer'])->name('appointment.customer');

require __DIR__.'/auth.php';
