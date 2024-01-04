<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::post('teams/parse-csv-import', 'TeamController@parseCsvImport')->name('teams.parseCsvImport');
    Route::post('teams/process-csv-import', 'TeamController@processCsvImport')->name('teams.processCsvImport');
    Route::resource('teams', 'TeamController');

    // Contacted
    Route::delete('contacteds/destroy', 'ContactedController@massDestroy')->name('contacteds.massDestroy');
    Route::resource('contacteds', 'ContactedController');
    Route::get('contacteds/last-contacted/{userEndedId}', 'ContactedController@getLastContacted')->name('contacteds.lastContacted');

    // Related To
    Route::delete('related-tos/destroy', 'RelatedToController@massDestroy')->name('related-tos.massDestroy');
    Route::resource('related-tos', 'RelatedToController');

    // Email
    Route::delete('emails/destroy', 'EmailController@massDestroy')->name('emails.massDestroy');
    Route::resource('emails', 'EmailController');

    // Sms
    Route::delete('smss/destroy', 'SmsController@massDestroy')->name('smss.massDestroy');
    Route::resource('smss', 'SmsController');

    // Category
    Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/parse-csv-import', 'CategoryController@parseCsvImport')->name('categories.parseCsvImport');
    Route::post('categories/process-csv-import', 'CategoryController@processCsvImport')->name('categories.processCsvImport');
    Route::resource('categories', 'CategoryController');

    // Member Category
    Route::delete('member-categories/destroy', 'MemberCategoryController@massDestroy')->name('member-categories.massDestroy');
    Route::post('member-categories/parse-csv-import', 'MemberCategoryController@parseCsvImport')->name('member-categories.parseCsvImport');
    Route::post('member-categories/process-csv-import', 'MemberCategoryController@processCsvImport')->name('member-categories.processCsvImport');
    Route::resource('member-categories', 'MemberCategoryController');
    Route::post('member-categories/detach-users', 'MemberCategoryController@detachUsers')->name('member-categories.detachUsers');


    Route::get('team-members', 'TeamMembersController@index')->name('team-members.index');
    Route::post('team-members', 'TeamMembersController@invite')->name('team-members.invite');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
