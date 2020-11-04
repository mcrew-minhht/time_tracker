<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeTrackersController;
use App\Http\Controllers\ProjectManagersController;
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
    Route::get('/time_trackers/{id}/{id_project}/{employee_code}', [TimeTrackersController::class, 'show']);
    Route::post('/time_trackers/add_project', [TimeTrackersController::class, 'store']);
    Route::get('/project_managers', [ProjectManagersController::class, 'index'])->name('project_managers');
    Route::get('/project_managers/create', [ProjectManagersController::class, 'create'])->name('project_managers_create');
    Route::post('/project_managers/store', [ProjectManagersController::class, 'store'])->name('project_managers_store');
    Route::get('/project_managers/edit/{id}', [ProjectManagersController::class, 'edit'])->name('project_managers_edit');
    Route::post('/project_managers/update', [ProjectManagersController::class, 'update'])->name('project_managers_update');
});
