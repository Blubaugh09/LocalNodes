<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Email
    Route::apiResource('emails', 'EmailApiController');

    // Sms
    Route::apiResource('smss', 'SmsApiController');

    // Category
    Route::apiResource('categories', 'CategoryApiController');

    // Member Category
    Route::apiResource('member-categories', 'MemberCategoryApiController');
});
