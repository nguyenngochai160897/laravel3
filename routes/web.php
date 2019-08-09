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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => "admin"], function(){
    Route::get("dashboard", function(){
        return view("admin.dashboard.index");
    })->middleware("auth")->name("dashboard");

    Route::group(['prefix' => "category", "middleware" => ["auth", "isSuperAdmin"]], function(){
        Route::get("", "Admin\CategoryController@index")->name("admin.category.index");
        Route::get("add-new", "Admin\CategoryController@showFormAdd")->name("admin.category.showFormAdd");
        Route::post("add-new", "Admin\CategoryController@store")->name("admin.category.add");
        Route::get("update/{id}", "Admin\CategoryController@showFormUpdate")->name("admin.category.showFormUpdate");
        Route::post("update/{id}", "Admin\CategoryController@update")->name("admin.category.update");
        Route::get("delete/{id}", "Admin\CategoryController@delete")->name("admin.category.delete");
    });

    Route::group(['prefix' => "post", "middleware" => ["auth", "isAdmin"]], function(){
        Route::get("", "Admin\PostController@index")->name("admin.post.index");
        Route::get("add-new", "Admin\PostController@showFormAdd")->name("admin.post.showFormAdd");
        Route::post("add-new", "Admin\PostController@store")->name("admin.post.add");
        Route::get("update/{id}", "Admin\PostController@showFormUpdate")->name("admin.post.showFormUpdate");
        Route::post("update/{id}", "Admin\PostController@update")->name("admin.post.update");
        Route::get("delete/{id}", "Admin\PostController@delete")->name("admin.post.delete");
    });

    Route::get("login", "Admin\Auth\LoginController@showFormLogin")->name("admin.auth.showFormLogin");
    Route::post("login", "Admin\Auth\LoginController@login")->name("admin.auth.login");

    Route::get("logout", "Admin\Auth\LoginController@logout")->name("admin.auth.logout");
    Route::get("profile", "Admin\UserController@showProfile")->name("admin.showProfile");


    Route::get("forgot-password", function(){ return view("admin.user.forgotPassword");})->name("admin.showFormForgotPassword");
    Route::post("forgot-password", "Admin\Auth\ForgotPasswordController@forgotPassword");
    Route::get("reset-password/{token}", function(){ return view("admin.user.resetPassword");})->name("admin.showFormResetPassword");
    Route::post("reset-password/{token}", "Admin\Auth\ResetPasswordController@resetPassword")->name("admin.resetPassword");

});

Route::get("redirect/{driver}", "Admin\Auth\LoginController@redirectToProvider")->name('login.provider');
Route::get("callback/{driver}", "Admin\Auth\LoginController@handleProviderCallback");


//public

Route::group(["prefix" => "blog"], function(){
    Route::get("", "Client\IndexController@index")->name("public.index");
    Route::get("post/{id}", "Client\IndexController@showPost")->name("public.post");
    Route::get("category/{id}", "Client\IndexController@showCategory")->name("public.category");
});


