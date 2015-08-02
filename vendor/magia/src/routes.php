<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 18/06/15
 * Time: 22:53
 */

use Illuminate\Support\Facades\Route;


Route::group(['prefix'=> 'admin'], function()
{
    //Admin Dashboard
    Route::get('/', array(
        'as' => 'admin_dashboard',
        'uses' => 'Magia\Controller\AdminController@dashboard',
    ));

    Route::get('{model}', array(
        'as' => 'admin_index',
        'uses' => 'Magia\Controller\AdminController@modelList'
    ));

    Route::get('{model}/{id}', array(
        'as' => 'admin_edit',
        'uses' => 'Magia\Controller\AdminController@edit'
    ));

    Route::post('{model}/{id}', array(
        'as' => 'admin_post',
        'uses' => 'Magia\Controller\AdminController@postEdit'
    ));
});