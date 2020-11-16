<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeTrackersController;
use App\Http\Controllers\ProjectManagersController;
use App\Http\Controllers\StatisticalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/
/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/

Route::group(['prefix' => '/',  'middleware' => 'auth:sanctum','verified'], function()
{
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('time_trackers', TimeTrackersController::class);
    Route::get('/time_trackers', [TimeTrackersController::class, 'index'])->name('time_trackers');
    Route::post('/time_trackers', [TimeTrackersController::class, 'index']);
    Route::post('/time_trackers/add_project', [TimeTrackersController::class, 'store']);
    Route::post('/time_trackers/destroy', [TimeTrackersController::class, 'destroy']);
    Route::get('/project_managers', [ProjectManagersController::class, 'index'])->name('project_managers');
    Route::get('/project_managers/create', [ProjectManagersController::class, 'create'])->name('project_managers_create');
    Route::post('/project_managers/store', [ProjectManagersController::class, 'store'])->name('project_managers_store');
    Route::get('/project_managers/edit/{id}', [ProjectManagersController::class, 'edit'])->name('project_managers_edit');
    Route::post('/project_managers/update', [ProjectManagersController::class, 'update'])->name('project_managers_update');
    Route::post('/project_managers/destroy', [ProjectManagersController::class, 'destroy'])->name('project_managers_destroy');


    Route::get('/statistical_project', [StatisticalController::class, 'statistical_project'])->name('statistical_project');
    Route::post('/statistical_project', [StatisticalController::class, 'statistical_project']);
    Route::get('/statistical_month', [StatisticalController::class, 'statistical_month'])->name('statistical_month');
    Route::post('/statistical_month', [StatisticalController::class, 'statistical_month']);
    Route::get('/pdf_project', [StatisticalController::class, 'pdf_project'])->name('pdf_project');
    Route::get('/pdf_month', [StatisticalController::class, 'pdf_month'])->name('pdf_month');


    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users_create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users_store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users_edit');
    Route::post('/users/update', [UserController::class, 'update'])->name('pusers_update');
    Route::post('/users/destroy', [UserController::class, 'destroy'])->name('users_destroy');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile_update');
    Route::post('/profile/confirm-password', [ProfileController::class, 'confirmPassword'])->name('profile-confirm-password');

});
