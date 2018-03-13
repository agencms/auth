<?php

namespace Silvanite\Brandenburg;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::prefix('agencms-auth')
    ->namespace('Agencms\Auth\Controllers')
    ->middleware(['api', 'cors'])
    ->group(function () {
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
