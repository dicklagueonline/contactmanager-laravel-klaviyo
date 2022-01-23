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

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'ContactController@index')->name('user.contact.index');

    Route::prefix('user')->group(function () {
        Route::get('/trackme', 'TrackActivity@trackme')->name('user.trackme');

        Route::get('/contact/lists', 'ContactController@list')->name('user.contact.lists');

        Route::resource('contact', 'ContactController')
            ->only(['store', 'update', 'destroy'])
            ->names([
                'store' => 'user.contact.store',
                'update' => 'user.contact.update',
                'destroy' => 'user.contact.destroy'
            ]);
    });

    Route::prefix('import')->group(function () {
        Route::post('/contact/upload', 'ImportContactController@loadFile')->name('import.cotact.loadfile');
        Route::post('/contact/{importdata}/map', 'ImportContactController@mapColumn')->name('import.contact.mapping');
        Route::post('/contact/{importdata}/process', 'ImportContactController@processImport')->name('import.contact.process');
        Route::post('/contact/{importdata}/cancel', 'ImportContactController@cancelImport')->name('import.contact.cancel');
    });
});
