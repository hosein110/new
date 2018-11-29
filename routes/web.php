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

use App\User;
Route::get('/', function () {
    $users = User::limit(10)->orderBy('id', 'DESC')->get();
    return view('welcome', compact('users'));
})->middleware('auth');


Route::namespace('admin')->group(function () {

    Route::group(['prefix' => '/admin'], function () {

        Route::group(['prefix' => '/home'], function () {
            Route::get('/', 'HomeController@index')->name('home')->middleware('can:dashboard');
            Route::get('/summary', 'HomeController@summary');

            Route::get('/analyzes/analyzes_summary/{site}', 'HomeController@analyzes_summary');

            Route::get('/analyzes', 'HomeController@analyzes')->middleware('can:analyzes');
            Route::get('/analyzes/site', 'HomeController@analyzes')->middleware('can:analyzes');
            Route::get('/analyzes_keywords', 'HomeController@analyzes_keywords')->middleware('can:analyzes');
            Route::get('/analyzes_links', 'HomeController@analyzes_links')->middleware('can:analyzes');

            Route::get('/siteMap', 'HomeController@siteMap');



        });
        Route::group(['prefix' => '/user'], function () {
            Route::patch('admin_modify_profile', 'UsersController@modifyProfile')->name('admin_modify_profile')->middleware('can:modify_profile');
            Route::get('new_user', 'UsersController@showUserForm')->middleware('can:new_user_form');
            Route::post('save', 'UsersController@save')->name('save')->middleware('can:insert_user');
            Route::get('profile', 'UsersController@showProfile')->middleware('can:profile');
            Route::get('users_list', 'UsersController@showUsersList')->middleware('can:users_list');
            Route::get('{id}/edit_user_form', 'UsersController@editForm')->name('edit_user_form')->middleware('can:edit_user_form');
            Route::post('users/{id}/edit_user', 'UsersController@modifyUser')->name('edit_user')->middleware('can:edit_user');
            Route::get('app_report_list', 'UsersController@app_report_list')->middleware('can:app_report_list');
            Route::get('getLogout', 'UsersController@getLogout')->name('getLogout');
        });


        Route::group(['prefix' => '/role'], function () {
            Route::get('new_role', 'RolesController@showNewForm')->name('new_role');
            Route::get('setPermission', 'RolesController@setPermissionForm')->name('setPermission');
            Route::patch('modifyPermissionRole', 'RolesController@modifyPermissionRole')->name('modifyPermissionRole');
            Route::patch('{id}/modifyPermission', 'RolesController@modifyPermission')->name('modifyPermission');
            Route::patch('{id}/modifyRole', 'RolesController@modifyRole')->name('modifyRole');
            Route::get('{id}/deleteRole', 'RolesController@deleteRole')->name('deleteRole');
            Route::get('{id}/deletePermission', 'RolesController@deletePermission')->name('deletePermission');
            Route::post('createRole', 'RolesController@createRole')->name('createRole');
            Route::post('createPermission', 'RolesController@createPermission')->name('createPermission');
            Route::get('{id}/edit_role', 'RolesController@showEditRoleForm')->name('edit_role');
            Route::get('{id}/edit_permission', 'RolesController@showEditPermissionForm')->name('edit_permission');


        });


        Route::group(['prefix' => '/location'], function () {
            Route::get('/list/{type}', 'LocationController@index')->name('admin_location_list')->middleware('can:location_list');
            Route::get('/create', 'LocationController@create')->name('create_location')->middleware('can:location_create_form');
            Route::post('/store_location', 'LocationController@store')->name('store_location')->middleware('can:location_store');
            Route::get('/getCity/{id}', 'LocationController@getCity')->middleware('can:location_create_form');

            Route::get('/edit/image_delete/{id}', 'LocationController@image_delete')->middleware('can:location_image_delete');

            Route::get('/edit/getCity/{id}', 'LocationController@getCity')->middleware('can:location_image_delete');

            Route::get('/edit/{id}/{type}', 'LocationController@edit')->name('edit_location')->middleware('can:location_edit_form');
            Route::get('/category', 'LocationController@category')->name('category')->middleware('can:location_edit_form');

            Route::patch('/update/{id}', 'LocationController@update')->name('update_location')->middleware('can:location_modify');

            Route::get('/admin_delete_location/{id}/{type}', 'LocationController@delete')->name('admin_delete_location')->middleware('can:location_edit_form');
            Route::get('/location_report_not_correct/{id}/{type}', 'LocationController@location_report_not_correct')->name('location_report_not_correct')->middleware('can:location_edit_form');
            Route::get('/admin_confirm_location/{id}/{type}', 'LocationController@admin_confirm_location')->name('admin_confirm_location')->middleware('can:location_edit_form');

        });
        Route::group(['prefix' => '/post'], function () {
            Route::get('/list/{type}', 'PostController@index')->name('admin_post_list')->middleware('can:post_list');
            Route::get('/confirm/{post_id}', 'PostController@confirm')->name('admin_post_confirm')->middleware('can:post_confirm');
            Route::get('/admin_delete_post/{id}', 'PostController@delete')->name('admin_delete_post')->middleware('can:post_delete');
            Route::get('/report_not_correct/{id}', 'PostController@report_not_correct')->name('report_not_correct')->middleware('can:post_report_not_correct');
        });
        Route::group(['prefix' => '/categories'], function () {
            Route::get('/list', 'CategoryController@index')->name('categories_list')->middleware('can:categories');
            Route::post('/store', 'CategoryController@store')->name('categories_create')->middleware('can:categories');
            Route::get('/sub_categories/{category}', 'CategoryController@sub_category_list')->name('sub_categories')->middleware('can:categories');
            Route::post('/sub_categories/store', 'CategoryController@sub_category_store')->name('sub_categories_create')->middleware('can:categories');
            Route::post('/sub_categories/sub_categoriesEdit', 'CategoryController@sub_categories_edit')->name('sub_categories_edit');
        });

    });



});
Route::get('/test','ApplicationController@test');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
