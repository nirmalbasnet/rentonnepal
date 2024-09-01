<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 30-Nov-20
 * Time: 6:26 PM
 */

Route::get('login', function () {
    if(\Illuminate\Support\Facades\Auth::check()){
        return redirect("dashboard");
    }
    return view('ui.login');
});

Route::get('admin/login', function () {
    if(\Illuminate\Support\Facades\Auth::check()){
        return redirect("dashboard");
    }
    return view('login');
});

//Route::get('register', function () {
//    return view('register');
//});

//Route::post('register', 'Auth\RegisterController@register');
Route::post('admin/login', 'Auth\LoginController@login');

Route::get('{socialMedia}/login', 'Auth\LoginController@socialLogin');
Route::get('{socialMedia}/redirect', 'Auth\LoginController@socialLoginRedirect');

Route::get('agent/{socialMedia}/login', 'Auth\LoginController@agentSocialLogin');
Route::get('agent/{socialMedia}/redirect', 'Auth\LoginController@agentSocialLoginRedirect');

Route::get('logout', 'Auth\LoginController@logout')->middleware("preventBackHistory");