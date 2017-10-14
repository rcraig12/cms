<?php

use RCS\CMS\Models\DataType;

/*
|--------------------------------------------------------------------------
| CMS Routes
|--------------------------------------------------------------------------
|
| This file is where you may override any of the routes that are included
| with CMS.
|
*/

Route::group(['as' => 'cms.'], function () {
    event('cms.routing', app('router'));

    $namespacePrefix = '\\'.config('cms.controllers.namespace').'\\';

    Route::get('login', ['uses' => $namespacePrefix.'CMSAuthController@login',     'as' => 'login']);
    Route::post('login', ['uses' => $namespacePrefix.'CMSAuthController@postLogin', 'as' => 'postlogin']);

    Route::group(['middleware' => 'admin.user'], function () use ($namespacePrefix) {
        event('cms.admin.routing', app('router'));

        // Main Admin and Logout Route
        Route::get('/', ['uses' => $namespacePrefix.'CMSController@index',   'as' => 'dashboard']);
        Route::post('logout', ['uses' => $namespacePrefix.'CMSController@logout',  'as' => 'logout']);
        Route::post('upload', ['uses' => $namespacePrefix.'CMSController@upload',  'as' => 'upload']);

        Route::get('profile', ['uses' => $namespacePrefix.'CMSController@profile', 'as' => 'profile']);

        try {
            foreach (DataType::all() as $dataType) {
                $breadController = $dataType->controller
                                 ? $dataType->controller
                                 : $namespacePrefix.'CMSBreadController';

                Route::resource($dataType->slug, $breadController);
            }
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException("Custom routes hasn't been configured because: ".$e->getMessage(), 1);
        } catch (\Exception $e) {
            // do nothing, might just be because table not yet migrated.
        }

        // Role Routes
        Route::resource('roles', $namespacePrefix.'CMSRoleController');

        // Menu Routes
        Route::group([
            'as'     => 'menus.',
            'prefix' => 'menus/{menu}',
        ], function () use ($namespacePrefix) {
            Route::get('builder', ['uses' => $namespacePrefix.'CMSMenuController@builder',    'as' => 'builder']);
            Route::post('order', ['uses' => $namespacePrefix.'CMSMenuController@order_item', 'as' => 'order']);

            Route::group([
                'as'     => 'item.',
                'prefix' => 'item',
            ], function () use ($namespacePrefix) {
                Route::delete('{id}', ['uses' => $namespacePrefix.'CMSMenuController@delete_menu', 'as' => 'destroy']);
                Route::post('/', ['uses' => $namespacePrefix.'CMSMenuController@add_item',    'as' => 'add']);
                Route::put('/', ['uses' => $namespacePrefix.'CMSMenuController@update_item', 'as' => 'update']);
            });
        });

        // Settings
        Route::group([
            'as'     => 'settings.',
            'prefix' => 'settings',
        ], function () use ($namespacePrefix) {
            Route::get('/', ['uses' => $namespacePrefix.'CMSSettingsController@index',        'as' => 'index']);
            Route::post('/', ['uses' => $namespacePrefix.'CMSSettingsController@store',        'as' => 'store']);
            Route::put('/', ['uses' => $namespacePrefix.'CMSSettingsController@update',       'as' => 'update']);
            Route::delete('{id}', ['uses' => $namespacePrefix.'CMSSettingsController@delete',       'as' => 'delete']);
            Route::get('{id}/move_up', ['uses' => $namespacePrefix.'CMSSettingsController@move_up',      'as' => 'move_up']);
            Route::get('{id}/move_down', ['uses' => $namespacePrefix.'CMSSettingsController@move_down',    'as' => 'move_down']);
            Route::get('{id}/delete_value', ['uses' => $namespacePrefix.'CMSSettingsController@delete_value', 'as' => 'delete_value']);
        });

        // Admin Media
        Route::group([
            'as'     => 'media.',
            'prefix' => 'media',
        ], function () use ($namespacePrefix) {
            Route::get('/', ['uses' => $namespacePrefix.'CMSMediaController@index',              'as' => 'index']);
            Route::post('files', ['uses' => $namespacePrefix.'CMSMediaController@files',              'as' => 'files']);
            Route::post('new_folder', ['uses' => $namespacePrefix.'CMSMediaController@new_folder',         'as' => 'new_folder']);
            Route::post('delete_file_folder', ['uses' => $namespacePrefix.'CMSMediaController@delete_file_folder', 'as' => 'delete_file_folder']);
            Route::post('directories', ['uses' => $namespacePrefix.'CMSMediaController@get_all_dirs',       'as' => 'get_all_dirs']);
            Route::post('move_file', ['uses' => $namespacePrefix.'CMSMediaController@move_file',          'as' => 'move_file']);
            Route::post('rename_file', ['uses' => $namespacePrefix.'CMSMediaController@rename_file',        'as' => 'rename_file']);
            Route::post('upload', ['uses' => $namespacePrefix.'CMSMediaController@upload',             'as' => 'upload']);
            Route::post('remove', ['uses' => $namespacePrefix.'CMSMediaController@remove',             'as' => 'remove']);
        });

        // Database Routes
        Route::group([
            'as'     => 'database.bread.',
            'prefix' => 'database',
        ], function () use ($namespacePrefix) {
            Route::get('{table}/bread/create', ['uses' => $namespacePrefix.'CMSDatabaseController@addBread',     'as' => 'create']);
            Route::post('bread', ['uses' => $namespacePrefix.'CMSDatabaseController@storeBread',   'as' => 'store']);
            Route::get('{table}/bread/edit', ['uses' => $namespacePrefix.'CMSDatabaseController@addEditBread', 'as' => 'edit']);
            Route::put('bread/{id}', ['uses' => $namespacePrefix.'CMSDatabaseController@updateBread',  'as' => 'update']);
            Route::delete('bread/{id}', ['uses' => $namespacePrefix.'CMSDatabaseController@deleteBread',  'as' => 'delete']);
        });

        Route::resource('database', $namespacePrefix.'CMSDatabaseController');
    });
});