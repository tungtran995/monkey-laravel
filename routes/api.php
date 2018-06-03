<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' =>  'cors' ], function () {
 Route::post('auth/register', 'UserController@register');
 Route::post('auth/login', 'UserController@login');
 Route::get('auth/me', 'UserController@profile');
 Route::get('auth/logout', 'UserController@logout');
});
Route::group(['middleware' =>  ['jwt.auth', 'cors'] ], function () {
    
    Route::get('getUser/{id}', 'UserController@show');
    
    // Get list of Menus
    Route::get('getMenus','MenuController@index');
    
    // Get specific Menu
    Route::get('getMenu/{id}','MenuController@show');
    
    // Delete a Menu
    Route::delete('deleteMenu/{id}','MenuController@destroy');
    
    // Update existing Menu
    Route::put('updateMenu/{id}','MenuController@update');
    
    // Create new Menu
    Route::post('createMenu','MenuController@store');
});

