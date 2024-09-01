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

Route::group(["middleware" => ["auth", "preventBackHistory"]], function () {
    Route::group(["prefix" => "dashboard"], function () {
        Route::get('/', "Dashboard\DashboardController@index");

        Route::group(["prefix" => "posts", "middleware" => ['role:admin|agent|tenant']], function () {
            Route::get('/', "Dashboard\PostController@index");
            Route::get('create', "Dashboard\PostController@create")->middleware('role:agent|admin|tenant');
            Route::post('store', "Dashboard\PostController@store")->middleware('role:agent|admin|tenant');
            Route::get('{id}/edit', "Dashboard\PostController@edit")->middleware('role:agent|admin|tenant');
            Route::get('{id}/details', "Dashboard\PostController@details");
            Route::patch('{id}/update', "Dashboard\PostController@update")->middleware('role:agent|admin|tenant');
            Route::get('{id}/change-publish-status', "Dashboard\PostController@changePublishStatus")->middleware('role:admin');
            Route::get('{id}/change-category-status', "Dashboard\PostController@changeCategoryStatus")->middleware('role:agent|admin|tenant');
        });

        Route::group(["prefix" => "agents", "middleware" => ['role:admin']], function () {
            Route::get('/', "Dashboard\AgentController@index");
            Route::get('create', "Dashboard\AgentController@create");
            Route::post('store', "Dashboard\AgentController@store");
            Route::get('{id}/edit', "Dashboard\AgentController@edit");
            Route::get('{id}/details', "Dashboard\AgentController@details");
            Route::patch('{id}/update', "Dashboard\AgentController@update");
            Route::get('{id}/change-status', "Dashboard\AgentController@changeStatus");
        });

        Route::group(["prefix" => "post-image"], function () {
            Route::get('{id}/delete', "Dashboard\PostController@deletePostImage")->middleware('role:agent');
        });

        Route::group(["prefix" => "contacts", "middleware" => ['role:admin']], function () {
            Route::get('/', "Dashboard\ContactDetailController@index");
            Route::post('store', "Dashboard\ContactDetailController@store");
        });

        Route::group(["prefix" => "newsletter-subscribers", "middleware" => ['role:admin']], function () {
            Route::get('/', "Dashboard\NewsLetterController@subscribers");
        });

        Route::group(["prefix" => "messages", "middleware" => ['role:admin']], function () {
            Route::get('/', "Dashboard\MessageController@index");
            Route::get('{id}/respond', "Dashboard\MessageController@respond");
        });

        Route::group(["prefix" => "profile"], function () {
            Route::get('/', "Dashboard\ProfileController@index");
            Route::get('edit', "Dashboard\ProfileController@edit");
            Route::post('update', "Dashboard\ProfileController@update");
        });

        Route::group(["prefix" => "agent-rating", "middleware" => ['role:admin']], function () {
            Route::get('/', "Dashboard\AgentRatingController@index");
            Route::get('{id}/change-publish-status', "Dashboard\AgentRatingController@changePublishStatus")->middleware('role:admin');
            Route::get('{id}/delete', "Dashboard\AgentRatingController@delete")->middleware('role:admin');
        });

        Route::group(["prefix" => "users", "middleware" => ['role:admin']], function () {
            Route::get('/', "Dashboard\UserController@index");
            Route::get('{id}/change-status', "Dashboard\UserController@changeStatus");
        });
    });
});

