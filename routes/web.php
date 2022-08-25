<?php

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

Auth::routes();

Route::get('/' , 'HomeController@index')->name('/');
Route::post('profile/update/{id}' , 'ProfileController@update')->name('profile/update/{id}');

Route::get('profile' , 'ProfileController@index')->name('profile/index');

Route::resource('/admin/status' , 'StatusController' , ['names' => [
    'index' => '/admin/status' ,
    'store' => '/admin/status/store' ,
    'destroy' => 'status/destroy'
]]);
Route::post('/admin/status/{id_status}/update' , ['as' => '/admin/status/{id_status}/update' , 'uses' => 'StatusController@update']);

Route::resource('/admin/user' , 'UserController' , ['names' => [
    'index' => '/admin/user' ,
    'create' => '/admin/user/create' ,
    'store' => '/admin/user/store' ,
    'destroy' => 'user/destroy'
]]);
Route::post('/admin/user/{id}/update' , ['as' => '/admin/user/{id}/update' , 'uses' => 'UserController@update']);

Route::resource('/master/transport' , 'TransportController' , ['names' => [
    'index' => '/master/transport' ,
    'store' => '/master/transport/store' ,
    'destroy' => 'transport/destroy'
]]);
Route::post('/master/transport/{id_transport}/update' , ['as' => '/master/transport/{id_transport}/update' , 'uses' => 'TransportController@update']);

Route::resource('/master/customers' , 'CustomersController' , ['names' => [
    'index' => '/master/customers' ,
    'store' => '/master/customers/store' ,
    'destroy' => 'customers/destroy'
]]);
Route::post('/master/customers/{id_customers}/update' , ['as' => '/master/customers/{id_customers}/update' , 'uses' => 'CustomersController@update']);

Route::resource('/master/units' , 'UnitsController' , ['names' => [
    'index' => '/master/units' ,
    'store' => '/master/units/store' ,
    'destroy' => 'units/destroy'
]]);
Route::post('/master/units/{id_units}/update' , ['as' => '/master/units/{id_units}/update' , 'uses' => 'UnitsController@update']);

Route::resource('/master/item' , 'ItemController' , ['names' => [
    'index' => '/master/item' ,
    'store' => '/master/item/store' ,
    'destroy' => 'item/destroy'
]]);
Route::post('/master/item/{id_item}/update' , ['as' => '/master/item/{id_item}/update' , 'uses' => 'ItemController@update']);

Route::resource('/master/warehouse' , 'WarehouseController' , ['names' => [
    'index' => '/master/warehouse' ,
    'store' => '/master/warehouse/store' ,
    'destroy' => 'warehouse/destroy'
]]);
Route::post('/master/warehouse/{id_warehouse}/update' , ['as' => '/master/warehouse/{id_warehouse}/update' , 'uses' => 'WarehouseController@update']);

Route::resource('/master/documents' , 'DocumentController' , ['names' => [
    'index' => '/master/documents' ,
    'store' => '/master/documents/store' ,
    'destroy' => 'documents/destroy'
]]);
Route::post('/master/documents/{id_doc}/update' , ['as' => '/master/documents/{id_doc}/update' , 'uses' => 'DocumentController@update']);

Route::resource('inbound_orders' , 'InboundOrdersController' , ['only' => [
    'create' , 'index' , 'store'
]]);
Route::get('inbound_orders/items' , ['as' => 'inbound_orders/items' , 'uses' => 'InboundOrdersController@items']);
Route::get('inbound_orders/edit/{id_ciord}' , ['as' => 'inbound_orders/edit/{id_ciord}' , 'uses' => 'InboundOrdersController@edit']);
Route::get('inbound_orders/show/{id_ciord}' , ['as' => 'inbound_orders/show/{id_ciord}' , 'uses' => 'InboundOrdersController@show']);
Route::post('inbound_orders/update/{id_ciord}' , ['as' => 'inbound_orders/update/{id_ciord}' , 'uses' => 'InboundOrdersController@update']);
Route::get('inbound_orders/email' , 'InboundOrdersController@email');

Route::resource('inventory' , 'InventoryController' , ['only' => [
    'index' , 'create' , 'store'
]]);
Route::get('inventory/customer' , ['as' => 'inventory/customer' , 'uses' => 'InventoryController@customer']);
Route::get('inventory/delivery' , ['as' => 'inventory/delivery' , 'uses' => 'InventoryController@delivery']);
Route::get('inventory/transport' , ['as' => 'inventory/transport' , 'uses' => 'InventoryController@transport']);
Route::get('inventory/sale' , ['as' => 'inventory/sale' , 'uses' => 'InventoryController@sale']);
Route::get('inventory/transfer' , ['as' => 'inventory/transfer' , 'uses' => 'InventoryController@transfer']);
Route::post('inventory/update' , ['as' => 'inventory/update' , 'uses' => 'InventoryController@update']);
Route::get('inventory/modal_detalle' , ['as' => 'inventory/modal_detalle' , 'uses' => 'InventoryController@modal_detalle']);

Route::resource('sales_inventory' , 'SaleInventoryController' , ['only' => [
    'store' , 'index'
]]);
Route::get('inventory/sale/show/{id_csale_inventory}' , ['as' => 'inventory/show/{id_csale_inventory}' , 'uses' => 'SaleInventoryController@show']);
Route::get('inventory/sale/pdf/{id_csale_inventory}' , 'SaleInventoryController@pdf');
Route::post('inventory/sale/update/{id_csale_inventory}' , ['as' => 'inventory/sale/update/{id_csale_inventory}' , 'uses' => 'SaleInventoryController@update']);
Route::get('inventory/sale/email' , 'SaleInventoryController@email');
Route::get('inventory/batch' , 'SaleInventoryController@batch');
Route::get('inventory/sale/pdf_batch' , 'SaleInventoryController@pdf_batch');