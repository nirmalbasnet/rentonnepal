<?php

Route::group(["namespace" => "Frontend"], function(){
    Route::get('/', "HomeController@index");

    Route::get('become-agent', "AgentController@becomeAgent");

    Route::get('complete-profile/{slug}', 'AgentController@completeProfile');
    Route::post('complete-profile/{slug}/submit', 'AgentController@completeProfile');

    Route::get('invalid-request', 'AgentController@invalidRequest');

    Route::group(['prefix' => 'newsletter'], function(){
        Route::get("subscribe", "NewsLetterController@subscribe");
    });

    Route::group(['prefix' => 'properties'], function(){
        Route::get("/", "PropertyController@index");
        Route::get("buy", "PropertyController@buy");
        Route::get("rent", "PropertyController@rent");
        Route::get("search", "PropertyController@search");
        Route::get("{category}/{subCategory}/{slug}", "PropertyController@details");
    });

    Route::group(['prefix' => 'contact'], function(){
        Route::get("/", "ContactController@index");
        Route::post("submit", "ContactController@submit");
    });

    Route::group(['prefix' => 'agents'], function(){
        Route::get("/", "AgentController@index");
        Route::get("{agentSlug}", "AgentController@detail");
        Route::get("{agentSlug}/properties", "AgentController@agentProperties");
        Route::post("{agentSlug}/submit-review", "AgentController@agentReviewSubmit");
        Route::get('{id}/load-more-rating', "AgentController@loadMoreRating");
    });

    Route::group(['prefix' => 'user'], function(){
        Route::get("{agentSlug}/properties", "AgentController@agentProperties");
    });

    Route::group(['prefix' => 'privacy'], function(){
        Route::get("/", "PrivacyController@index");
    });
});