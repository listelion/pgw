<?php
use App\Address;
use App\Finder;
use Illuminate\Http\Request;
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

Route::resource('material', 'MaterialController');
Route::resource('recipe', 'RecipeController');
Route::resource('produce', 'ProduceController');
Route::get('/produce/{produce_id}/create', 'ProduceController@create');

Route::get('/material/{material_id}/create', 'Material_logController@create');
Route::post('/material/{material_id}', 'Material_logController@store');
Route::get('/material/{material_id}/edit/{id}', 'Material_logController@edit');
Route::put('/material/{material_id}/update/{id}', 'Material_logController@update');
Route::delete('/material/{material_id}/delete/{id}', 'Material_logController@destroy');

Route::get('/recipe/{recipe_id}/create', 'Recipe_detailController@create');
Route::post('/recipe/{recipe_id}', 'Recipe_detailController@store');
Route::get('/recipe/{recipe_id}/edit/{id}', 'Recipe_detailController@edit');
Route::put('/recipe/{recipe_id}/update/{id}', 'Recipe_detailController@update');
Route::delete('/recipe/{recipe_id}/delete/{id}', 'Recipe_detailController@destroy');

Route::get('/invoice', 'InvoiceController@index');
Route::post('/invoice', 'InvoiceController@store');
Route::get('/invoice/{id}', 'InvoiceController@edit');
Route::post('/invoice/send', 'InvoiceController@send');
Route::post('/invoice/{id}', 'InvoiceController@jang');
Route::get('/invoice/{id}/send_msg', 'InvoiceController@sendMessage');

Route::get('/deposit', 'DepositController@index');
Route::get('/deposit/{id}', 'DepositController@view');
Route::post('/deposit/{id}', 'DepositController@deposit_yn');

Route::get('/closing', 'ClosingController@index');
Route::get('/closing/write', 'ClosingController@write');
Route::post('/closing', 'ClosingController@store');

Route::get('/rank', 'RankController@index');

Route::get('/address', 'AddressController@index');
Route::post('/address', 'AddressController@store');
Route::get('/address/{id}', 'AddressController@edit');
Route::post('/address/{id}', 'AddressController@edit_store');
Route::get('/address/delete/{id}', 'AddressController@delete');
Route::get('/address/label/{id}', 'AddressController@label');

Route::get('/product', 'ProductController@index');
Route::post('/product', 'ProductController@store');
Route::get('/product_write', 'ProductController@write');
Route::get('/product/{id}', 'ProductController@edit');
Route::post('/product/{id}', 'ProductController@edit_store');
Route::post('/product_write', 'ProductController@write_store');

Route::get('/inven', 'InvenController@index');
Route::post('/inven_write', 'InvenController@store');
Route::get('/inven/write', 'InvenController@write');

Route::get('/findnum', 'FindnumController@index');

Route::get('/finder', 'FinderController@index');
Route::post('/finder', 'FinderController@store');
Route::get('/finder/edit/{id}', 'FinderController@edit');
Route::post('/finder/edit/{id}', 'FinderController@edit_store');
Route::delete('/finder/{id}', 'FinderController@destroy');

Route::get('/code', 'CodeController@index');
Route::post('/code', 'CodeController@store');
Route::get('/code/write', 'CodeController@write');
Route::get('/code/{id}', 'CodeController@edit');
Route::post('/code/{id}', 'CodeController@write_store');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index2');
Auth::routes();


