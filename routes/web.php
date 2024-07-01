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
    return view('auth.login');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/botman', [App\Http\Controllers\BotManController::class, 'handle']);

Route::resource('/clients','App\Http\Controllers\ClientsController');

Route::resource('/ventes','App\Http\Controllers\VentesController');

Route::resource('/entreprises','App\Http\Controllers\EntreprisesController');

Route::resource('/devis','App\Http\Controllers\DevisController');

Route::get('/achats/show/{id}', [App\Http\Controllers\AchatsController::class,'show']);


Route::get('/View_file/{numero}/{nom}', 'App\Http\Controllers\FacturesController@OpenFile');
Route::get('/Download_file/{numero}/{nom}', 'App\Http\Controllers\FacturesController@GetFile');
Route::get('/destroy/{numero}/{nom}', 'App\Http\Controllers\FacturesController@destroy');
Route::get('/Facturesexport', [App\Http\Controllers\FacturesController::class, 'export']);
Route::get('/vue_all', [App\Http\Controllers\FacturesController::class, 'marquervue']);


Route::resource('/achats','App\Http\Controllers\AchatsController');


Route::get('/ventes/show/{id}', [App\Http\Controllers\VentesController::class, 'show']);
Route::get('/devis/show/{id}', [App\Http\Controllers\DevisController::class, 'show']);
Route::get('/audit_factures', [App\Http\Controllers\FacturesController::class, 'show']);


Route::get('/print/{id}', [App\Http\Controllers\FacturesController::class, 'print']);
Route::get('/print_devis/{id}', [App\Http\Controllers\DevisController::class, 'print']);
Route::get('/show/{id}', [App\Http\Controllers\FacturesController::class, 'afficher']);
Route::get('/show_devis/{id}', [App\Http\Controllers\DevisController::class, 'afficher']);
Route::get('/signer/{id}', [App\Http\Controllers\DevisController::class, 'signer']);
Route::get('/download/{id}', [App\Http\Controllers\FacturesController::class, 'download']);
Route::get('/envoyer/{id}', [App\Http\Controllers\DevisController::class, 'envoyer']);


Route::post('/ventes/show', 'App\Http\Controllers\VentesController@show');
Route::post('/recherche_factures', 'App\Http\Controllers\FacturesController@getfacture');
Route::get('/recherche_factures', 'App\Http\Controllers\FacturesController@getfacture');


Route::get('/section/{id}',[App\Http\Controllers\AchatsController::class,'getProducts']);
Route::get('/rapports',[App\Http\Controllers\FacturesController::class,'showshow']);

Route::get('/solde/{id}',[App\Http\Controllers\FacturesController::class,'getSolde']);

Route::get('/produit/{id}',[App\Http\Controllers\AchatsController::class,'getQuantites']);

Route::get('/notification',[App\Http\Controllers\AchatsController::class,'getNotif']);

Route::get('/produitUpdate1/{id}/{quantite}',[App\Http\Controllers\AchatsController::class,'getQuantites1']);

Route::post('/import', [App\Http\Controllers\ProductsController::class, 'import'])->name('import');


Route::get('/produitUpdate/{id}/{quantite}',[App\Http\Controllers\VentesController::class,'getQuantites']);
Route::get('/produitUpdateInsert/{id}',[App\Http\Controllers\VentesController::class,'getQuantitesInsert']);


Route::resource('/products','App\Http\Controllers\ProductsController');

Route::resource('/fournisseurs','App\Http\Controllers\FournisseursController');

Route::get('/registry',['App\Http\Controllers\AdminController@registry']);


Route::get('lang/{locale}', 'App\Http\Controllers\LanguageController@changeLanguage')->name('lang.change');

Route::post('/factures/recuperer', 'App\Http\Controllers\FacturesController@recuperer');
Route::post('/factures/destroy', 'App\Http\Controllers\FacturesController@forcedestroy');

Route::resource('/factures', 'App\Http\Controllers\FacturesController');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


Route::resource('/classes','App\Http\Controllers\ClassesController');


Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles', App\Http\Controllers\RoleController::class);

    Route::resource('users', App\Http\Controllers\UserController::class);


});


