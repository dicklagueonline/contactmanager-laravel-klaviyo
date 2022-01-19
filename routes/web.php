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

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    Route::get('/', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');

    Route::resource('contact', 'ContactController')->except(['index', 'show']);

    Route::prefix('import')->group(function() {
        Route::get('/contact', [App\Http\Controllers\ContactImportController::class, 'index'])->name('contact.import');
        Route::post('/contact/upload', [App\Http\Controllers\ContactImportController::class, 'loadFile'])->name('contact.import.upload');
        Route::get('/contact/map/{import_file_data}', [App\Http\Controllers\ContactImportController::class, 'mapImportFields'])->name('contact.import.map');
        Route::post('/contact/process', [App\Http\Controllers\ContactImportController::class, 'processImport'])->name('contact.import.process');
    });

    Route::get('/user/trackme', [App\Http\Controllers\TrackActivity::class, 'trackme'])->name('user.trackme');
});
