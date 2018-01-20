<?php

namespace Silvanite\Brandenburg;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

use Silvanite\Agencms\Config;
use Silvanite\Agencms\Route as AcmsRoute;

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

Route::prefix('agencms-auth')
     ->namespace('Silvanite\AgencmsAuth\Controllers')
     ->middleware(['api', 'cors'])
     ->group(function() {
        Route::resource('permissions', 'PermissionController');
        Route::resource('roles', 'RoleController');
        Route::resource('users', 'UserController');
        Route::resource('policies', 'PolicyController');
        Route::post('login', 'LoginController@login');
        Route::get('authorize', [
                 'as' => 'login', 
                 'uses' => 'LoginController@required'
               ]);
     });