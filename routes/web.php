<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeTrackersController;
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
});
