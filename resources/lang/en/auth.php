<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => __('These credentials do not match our records.'),
    'throttle' => __('Too many login attempts. Please try again in :seconds seconds.'),

    'email_not_verified' => 'You email is not verified!',
    'something_went_wrong' => 'Something went wrong',
    'logout_success' => 'Logout successfully',
    'registration_success' => 'Registered successfully!',

    'mpin' => [
        'mpin_not_valid' => 'Pin is not valid',
        'mpin_generate_success' => 'Pin generate successfully!',
        'mpin_update_success' => 'Pin updated successfully!',
        'old_mpin_wrong' => 'Old Pin is wrong!',
    ],

    'otp' => [
        'sent_success' => 'OTP sent successfully!',
        'invalid' => 'Invalid OTP!',
        'verification_success' => 'OTP verification successful!',
        'old_mpin_wrong' => 'Old Mpin is wrong!',
    ],

    'social_media' => [
        'login_success' => 'Login from :provider successfully!',
        'not_allowed' => 'Social media login is not allowed!',
    ],

    'change_password' => [
        'current_pwd_not_matched' => 'Current password does not matched!',
        'update_success' => 'Password changed successfully!',
    ],

    'forgot_password' => [
        'opt_sent_to_email' => 'OTP Sent successfully to your mail!',
        'otp_verification_successful' => 'OTP verification successful!',
        'invalid_otp' => 'Invalid OTP!',
        'reset_password_successful' => 'Password reset successfully!',
        'reset_password_failed' => 'Password reset failed!',
    ],
];
