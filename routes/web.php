<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Musicas;
use App\Http\Controllers\Editor;
use App\Http\Controllers\Acessos;
use App\Http\Controllers\Aprovacao;
use App\Http\Controllers\Pascom;
use App\Http\Controllers\Repertorios;
use App\Http\Controllers\RepertorioTemplates;
use App\Http\Controllers\Escalas;
use App\Http\Controllers\EscalaTemplates;
use App\Http\Controllers\Ministerios;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\WebNotificationController;

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

Route::group(['middleware' => 'web'], function(){
    Auth::routes();

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/push-notificaiton', [WebNotificationController::class, 'index'])->name('push-notificaiton');
Route::get('/get-notificaiton', [WebNotificationController::class, 'get'])->name('get-notificaiton');
Route::post('/store-token', [WebNotificationController::class, 'storeToken'])->name('store.token');
Route::post('/send-web-notification', [WebNotificationController::class, 'sendWebNotification'])->name('send-web-notification');

Route::get('/denied', [Acessos::class, 'denied'])->name('denied');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'musicas'], function(){
    Route::get('/', [Musicas::class, 'index']);
    Route::get('view/{id}', [Musicas::class, 'view']);
    Route::get('letra/{id}', [Musicas::class, 'letra']);
    Route::get('nova', [Musicas::class, 'nova']);
    Route::get('edit/{id}', [Musicas::class, 'edit']);
    Route::post('insert', [Musicas::class, 'insert']);
    Route::post('update', [Musicas::class, 'update']);
    Route::post('delete', [Musicas::class, 'delete']);
});

Route::group(['prefix'=>'escalas'], function(){
    Route::get('/', [Escalas::class, 'index']);
    Route::get('teste', [Escalas::class, 'teste']);
    Route::get('view/{id}', [Escalas::class, 'view']);
    Route::get('edit/{id}', [Escalas::class, 'edit']);
    Route::get('novo', [Escalas::class, 'novo']);
    Route::get('novo/{data}', [Escalas::class, 'missas']);
    Route::post('insert', [Escalas::class, 'insert']);
    Route::post('update', [Escalas::class, 'update']);
    Route::post('delete', [Escalas::class, 'delete']);
});

Route::group(['prefix'=>'escalaTemplates'], function(){
    Route::get('/', [EscalaTemplates::class, 'index']);
    Route::post('insert', [EscalaTemplates::class, 'insert']);
    Route::post('update', [EscalaTemplates::class, 'update']);
    Route::post('delete', [EscalaTemplates::class, 'delete']);
});

Route::group(['prefix'=>'repertorios'], function(){
    Route::get('/', [Repertorios::class, 'index']);
    Route::get('view/{id}', [Repertorios::class, 'view']);
    Route::get('edit/{id}', [Repertorios::class, 'edit']);
    Route::get('musicas/{id}', [Repertorios::class, 'musicas']);
    Route::get('novo/{idMinisterio}', [Repertorios::class, 'novo']);
    Route::get('novo', [Repertorios::class, 'novo']);
    Route::post('insert', [Repertorios::class, 'insert']);
    Route::post('update', [Repertorios::class, 'update']);
    Route::post('delete', [Repertorios::class, 'delete']);
});

Route::group(['prefix'=>'repertorioTemplates'], function(){
    Route::get('/', [RepertorioTemplates::class, 'index']);
    Route::post('insert', [RepertorioTemplates::class, 'insert']);
    Route::post('update', [RepertorioTemplates::class, 'update']);
    Route::post('delete', [RepertorioTemplates::class, 'delete']);
});

Route::group(['prefix'=>'ministerios'], function(){
    Route::get('/', [Ministerios::class, 'index']);
    Route::get('view/{id}', [Ministerios::class, 'view']);
    Route::get('novo', [Ministerios::class, 'novo']);
    Route::get('edit/{id}', [Ministerios::class, 'edit']);
    Route::post('insert', [Ministerios::class, 'insert']);
    Route::post('update', [Ministerios::class, 'update']);
    Route::post('delete', [Ministerios::class, 'delete']);
});

Route::group(['prefix'=>'acessos'], function(){
    Route::get('/', [Acessos::class, 'index']);
    Route::get('edit/{id}', [Acessos::class, 'edit']);
    Route::get('novo', [Acessos::class, 'novo']);
    Route::post('insert', [Acessos::class, 'insert']);
    Route::post('update', [Acessos::class, 'update']);
    Route::post('bloquear', [Acessos::class, 'bloquear']);
    Route::post('desbloquear', [Acessos::class, 'desbloquear']);
});

Route::group(['prefix'=>'aprovacao'], function(){
    Route::get('/', [Aprovacao::class, 'index']);
    Route::post('update', [Aprovacao::class, 'update']);
});

Route::group(['prefix'=>'pascom'], function(){
    Route::get('/', [Pascom::class, 'index']);
    Route::get('view/{id}', [Pascom::class, 'view']);
});

Route::group(['prefix'=>'editor'], function(){
    Route::get('/', [Editor::class, 'index']);
});

Route::group(['prefix'=>'session'], function(){
    Route::get('/', [SessionController::class, 'session']);
});