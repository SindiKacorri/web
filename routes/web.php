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

Route::get('/', 'HomeController@home');

// Authentication Routes...
Route::get('login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@showLoginForm'
]);

Route::post('login','Auth\LoginController@login');

Route::post('logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);

// Password Reset Routes...
Route::post('password/email', [
    'as' => 'password.email',
    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);

Route::get('password/reset', [ 'as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);

Route::post('password/reset', ['as' => 'password.update', 'uses' => 'Auth\ResetPasswordController@reset']);

Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);

// Registration Routes...
Route::get('register', [ 'as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);

Route::post('register', [ 'as' => '', 'uses' => 'Auth\RegisterController@register']);

Route::get('contact', 'HomeController@contactus');
Route::get('about', 'HomeController@aboutus');

Route::get('user/edit', 'UserController@editUser')->name('user.edit');
Route::post('user/update', 'UserController@updateUser')->name('user.update');

Route::get('product/{uuid}',['uses' => 'HomeController@viewProduct', 'as' => 'view.product']);
Route::get('search', ['uses' => 'HomeController@getSearch', 'as' => 'search']);
Route::get('our-products', ['uses' => 'HomeController@ourProducts', 'as' => 'our-products']);

Route::get('category/{name}', ['uses' => 'HomeController@viewCategory', 'as' => 'view.category']);

Route::get('orders', 'HomeController@viewOrder');
Route::post('order', 'HomeController@saveOrder');

Route::get('checkout', 'HomeController@checkout');


Route::get('admin-login', 'HomeController@getAdminLogin');
Route::post('admin-login', 'HomeController@postAdminLogin');

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function(){

	Route::get('dashboard', 'ProductSettingsController@settings');
	Route::get('product/create', 'ProductSettingsController@newProduct');

	//orders
	Route::get('orders/all', 'DashboardController@allOrders');
	Route::get('order/{id}', ['uses' => 'DashboardController@viewOrder', 'as' => 'view.order']);
	Route::get('confirm/order/{id}', ['uses' => 'DashboardController@confirmOrder', 'as' => 'confirm.order']);
	Route::get('cancel/order/{id}', ['uses' => 'DashboardController@cancelOrder', 'as' => 'cancel.order']);

	Route::post('product/create', 'DashboardController@newProduct');
	Route::get('products/all', 'DashboardController@allProducts');
	Route::get('product/edit/{id}', ['uses' => 'DashboardController@editProduct', 'as' => 'edit.product']);
	Route::post('product/edit/{id}', ['uses' => 'DashboardController@updateProduct', 'as' => 'update.product']);
	Route::post('product/image', 'DashboardController@productImage');

	//product settings create
	Route::post('category/create', 'ProductSettingsController@createCategory');
	Route::post('skin-type/create', 'ProductSettingsController@createSkintype');
	Route::post('color/create', 'ProductSettingsController@createColor');
	Route::post('size/create', 'ProductSettingsController@createSize');
	Route::post('material/create', 'ProductSettingsController@createMaterial');

	//product settings delete
	Route::post('category/{id}/delete', 'ProductSettingsController@deleteCategory');
	Route::post('skin-type/{id}/delete', 'ProductSettingsController@deleteSkintype');
	Route::post('color/{id}/delete', 'ProductSettingsController@deleteColor');
	Route::post('size/{id}/delete', 'ProductSettingsController@deleteSize');
	Route::post('material/{id}/delete', 'ProductSettingsController@deleteMaterial');
});
