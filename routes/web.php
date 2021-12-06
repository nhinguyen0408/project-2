<?php

use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\TimeKeepingController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\TimeManager;
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

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::prefix('salary')->name('salary.')->group(function () {
		Route::get('', [SalaryController::class, 'index' ] )->name('index');
		Route::get('/salary-calculation', [SalaryController::class, 'salary_calculation'])->name('salary-calculation');
        Route::get('/details/{id}', [SalaryController::class, 'details'])->name('details');
	});
	Route::resource('employees', EmployeesController::class);
	Route::prefix('time-keeping')->name('time-keeping.')->group(function () {
		Route::get('/', [TimeKeepingController::class, 'index'])->name('index');
		Route::get('/view/{id}', [TimeKeepingController::class, 'view'])->name('view');
		Route::get('/working/{id}', [TimeKeepingController::class, 'working'])->name('working');
		Route::post('/import-excel', [TimeKeepingController::class, 'importExcel'])->name('import-excel');
		Route::get('/reset', [TimeKeepingController::class, 'reset'])->name('reset');
	});
    Route::prefix('time-manager')->name('time-manager.')->group(function () {
        Route::get('/',[TimeManager::class, 'index'])->name('index');
        Route::get('/details/{id}', [TimeManager::class, 'details'])->name('details');
        Route::post('/on-leave', [TimeManager::class, 'onLeave'])->name('on-leave');
        Route::post('/off-leave', [TimeManager::class, 'offLeave'])->name('off-leave');
    });

});
