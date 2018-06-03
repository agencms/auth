<?php

namespace Silvanite\Brandenburg;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::prefix('agencms-auth')
    ->namespace('Agencms\Auth\Controllers')
    ->middleware(['api', 'cors', 'auth:api'])
    ->group(function () {
        Route::resource('permissions', 'PermissionController');
        Route::resource('roles', 'RoleController');
        Route::resource('users', 'UserController');
        Route::resource('profile', 'ProfileController');
        Route::resource('policies', 'PolicyController');
    });

Route::prefix('agencms-auth')
    ->namespace('Agencms\Auth\Controllers')
    ->middleware(['cors'])
    ->group(function () {
        Route::post('login', 'LoginController@login');
        Route::post('password/reset', 'PasswordController@reset')->name('password.reset');
        Route::post('password/request', 'PasswordController@request')->name('password.request');
        Route::get('authorize', [
            'as' => 'login',
            'uses' => 'LoginController@required'
        ]);
    });
