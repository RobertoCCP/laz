<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

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
    return view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/audits/generate-pdf', [AuditController::class, 'generatePDF'])->name('audits.generatePDF');

Route::get('/audits/likert', [AuditController::class, 'likert'])->name('audits.likert');
Route::get('audits/chart', [AuditController::class, 'chart'])->name('audits.chart');

Route::get('audits/chart', [AuditController::class, 'showChart'])->name('audits.chart');


Route::get('clientes/generate-pdf', [ClienteController::class, 'generatePDF'])->name('clientes.generatePDF');
Route::get('facturas/generate-pdf', [FacturaController::class, 'generatePDF'])->name('facturas.generatePDF');



//y creamos un grupo de rutas protegidas para los controladores
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('audits', AuditController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('facturas', FacturaController::class);


    Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
    Route::delete('/audits/{id}', [AuditController::class, 'destroy'])->name('audits.destroy');
    Route::get('/audits/{id}', [AuditController::class, 'show'])->name('audits.show');
    
    Route::post('/audits/destroyAll', 'AuditController@destroyAll')->name('audits.destroyAll');
});




// Route::group(['middleware' => 'no-access'], function () {
//     // Rutas a restringir
//     Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');
//     // Agrega aquí otras rutas a restringir
// });

Route::middleware(['2fa'])->group(function () {
   
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/2fa', function () {
        return redirect(route('home'));
    })->name('2fa');
});
  
Route::get('/complete-registration', [RegisterController::class, 'completeRegistration'])->name('complete.registration');