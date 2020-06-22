<?php
/*----------------------------- AUTHENTICATION ROUTES STARTS-----------------------------*/
Auth::routes(['name' => 'frontend.','verify' => true]);
Route::group(['namespace' => 'Auth'], function () {
    Route::get('login/{provider}', 'SocialAccountController@redirectToProvider')->name('social-media.login');
    Route::get('login/{provider}/callback', 'SocialAccountController@handleProviderCallback');
});

Route::group(['namespace' => 'User'], function () {
    Route::get('email-verification/{email}/{verification_code}', 'UserController@emailVerification')->name('email-verification');
});


/*----------------------------- AUTHENTICATION ROUTES ENDS-----------------------------*/

/*----------------------------- LANDING PAGE REDIRECTION -----------------------------*/
Route::view('/', 'backend.landing')->name('landing');
