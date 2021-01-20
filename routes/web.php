<?php

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

Route::get('/','App\Http\Controllers\HomeController@index')->name('dashboard');

Route::view('/home', 'home')->middleware(['auth', 'verified']);


Route::view('/profile/edit', 'profile.edit')->middleware('auth');
Route::view('/profile/password', 'profile.password')->middleware('auth');





Route::get('/register/{token}','App\Http\Controllers\Auth\RegisterController@showRegisterForm')->name('register.form');

Route::post('/register','App\Http\Controllers\Auth\RegisterController@postRegister')->name('register');

Route::middleware('auth')->group( function (){

    //Route::get('egresados','App\Http\Controllers\Admin\AdminController@allEgresados')->name('egresados.filtrar');

    //Route::get('tramites','AdminController@allTramites')->name('tramite.filtrar');

    //Route::get('citas','AdminController@allCitas')->name('citas.filtrar');

    //Route::get('citasNoEnviadas','Citas\CitasController@getCitasNoEnviadas')->name('citas.noEnviadas');

    
    Route::get('/register','App\Http\Controllers\Auth\RegisterController@getEmailRegister')->name('register.request');
    
    Route::post('/register/email','App\Http\Controllers\Auth\RegisterController@sendEmailRegister')->name('sendEmail.register');

    Route::get('egresados','App\Http\Controllers\Admin\AdminController@allEgresados')->name('egresados.filtrar');

    Route::get('/egresados/{id}/delete','App\Http\Controllers\Admin\AdminController@deleteEgresado')->name('egresados.delete');
    
    Route::get('tramites','App\Http\Controllers\Admin\AdminController@allTramites')->name('tramite.filtrar');

    Route::get('/tramites/{id}/','App\Http\Controllers\Admin\AdminController@getTramites')->name('egresados.tramites');

    Route::get('/tramite/{id}/finalizar','App\Http\Controllers\Admin\AdminController@finishTramite')->name('tramite.finish');

    Route::get('/tramites/{id}/delete','App\Http\Controllers\Admin\AdminController@deleteTramite')->name('tramites.delete');
    
    Route::get('citas','App\Http\Controllers\Admin\AdminController@allCitas')->name('citas.filtrar');
    
    Route::get('/citas/{id}/','App\Http\Controllers\Admin\AdminController@getCitas')->name('egresados.citas');

    Route::post('/citas/{id}','App\Http\Controllers\Admin\AdminController@postCitar')->name('citar');

    Route::get('/citas/{id}/delete','App\Http\Controllers\Admin\AdminController@deleteCita')->name('citas.delete');

    Route::get('citasNoEnviadas','App\Http\Controllers\Admin\Citas\CitasController@getCitasNoEnviadas')->name('citas.noEnviadas');
    
    Route::post('sendCitasPendientes','App\Http\Controllers\Admin\Citas\CitasController@sendMailsRestantes')->name('citas.enviarPendientes');

    Route::get('crearTramite','App\Http\Controllers\Admin\AdminController@getCreateTramite')->name('listaTramites');

    Route::post('createListaTramite','App\Http\Controllers\Admin\AdminController@storeTramite')->name('listaTramites.store');
    
    Route::get('deleteListaTramite/{id}/delete','App\Http\Controllers\Admin\AdminController@deleteListaTramite')->name('listraTramites.delete');

    Route::get('editListaTramite/{id}/edit','App\Http\Controllers\Admin\AdminController@editListaTramite')->name('listraTramites.edit');

    Route::patch('updateNameTramite/{id}/update','App\Http\Controllers\Admin\AdminController@updateNameTramite')->name('listraTramites.update');

    Route::get('downloadEgresados/{carrera}/{yearIngreso}/{yearEgreso}/{dateIngresoRange}/{dateEgresoRange}/{dateIngresoSpe}/{dateEgresoSpe}',[
        'as' => 'download.egresados',
        'uses' => 'App\Http\Controllers\Admin\DownloadsFilesController@downloadEgresados'
    ]);

    Route::get('downloadTramites/{tramite}/{carrera}/{yearIngreso}/{yearEgreso}/
    {dateIngresoRange}/{dateEgresoRange}/{dateIngresoSpe}/{dateEgresoSpe}',[
        'as' => 'download.tramites',
        'uses' => 'DownloadsFilesController@downloadTramites'
    ]);

    Route::get('downloadCitas/{tramite}/{carrera}',[
        'as' => 'download.citas',
        'uses' => 'DownloadsFilesController@downloadCitas'
    ]);

    Route::get('tramites_emails/{tramite}/{carrera}/{yearIngreso}/{yearEgreso}/
    {dateIngresoRange}/{dateEgresoRange}/{dateIngresoSpe}/{dateEgresoSpe}',[
        'as' => 'tramites_emails',
        'uses' => 'AdminController@getMails'
    ]);

    Route::post('sendEmails/{tramite}/{carrera}/{yearIngreso}/{yearEgreso}/
    {dateIngresoRange}/{dateEgresoRange}/{dateIngresoSpe}/{dateEgresoSpe}',[
        'as'   => 'citar.sendEmail',
        'uses' => 'AdminController@sendEmails'
    ]);
});