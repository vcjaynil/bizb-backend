<?php

namespace App\Repositories\Api\Access\User;

use App\Jobs\SendForgotPasswordOtp;
use App\Models\User;
use App\Models\UserSocialLogin;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserInterface
{

    /**
     * @author Jaynil Parekh
     * @since 2020-06-08
     * @var User
     *
     */
    protected $model;
    protected $userSocialLogin;

    /**
     * @param User $model
     * @param UserSocialLogin $userSocialLogin
     * @author Jaynil Parekh
     * @since 2020-06-08
     *
     * UserRepository constructor.
     *
     */
    public function __construct(User $model, UserSocialLogin $userSocialLogin)
    {
        $this->model = $model;
        $this->userSocialLogin = $userSocialLogin;
    }

    /**
     * @param $email
     *
     * @return bool
     * @author Jaynil Parekh
     * @since 2020-06-08
     *
     * Find user by email.
     */
    public function findByEmail($email)
    {
        return $this->model->query()->where('email', $email)->first();
    }

    /**
     * @param $id
     *
     * @return mixed
     * @author Jaynil Parekh
     * @since 2020-06-08
     *
     * Find user by id.
     *
     */
    public function findById($id)
    {
        return $this->model->query()->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @return bool
     * @author Jaynil Parekh
     * @since 2020-06-08
     *
     * Login verification and create token.
     *
     */
    public function loginVerification(array $data)
    {
        $response = [];

        try {

            $user = $this->findByEmail($data['email']);

            if (!empty($user) && Hash::check($data['password'], $user->password)) {

                if ($user->verification_confirmed != 1) {

                    $token = $user->createToken('app-token');

                    $userData['id'] = $user->id;
                    $userData['name'] = $user->name;
                    $userData['email'] = $user->email;
                    $userData['type'] = $user->type;

                    $response['token'] = $token->plainTextToken;
                    $response['user'] = $userData;

                } else {
                    $response['message'] = trans('auth.email_not_verified');
                    $response['status'] = 401;
                }
            } else {
                $response['message'] = trans('auth.failed');
                $response['status'] = 401;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['message'] = trans('auth.something-went_wrong');
            $response['status'] = 401;
        }
        return $response;
    }

    /**
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-08
     *
     * Mpin Login verification and create token.
     *
     */
    public function mPinloginVerification(array $data)
    {
        $response = [];

        try {

            $user = $this->findByEmail($data['email']);

            if (!empty($user)) {

                $mPin = getUserMetaValue($user->id, 'mpin');

                if (!empty($mPin) && Hash::check($data['mpin'], $mPin)) {

                    $token = $user->createToken('app-token');

                    $userData['id'] = $user->id;
                    $userData['name'] = $user->name;
                    $userData['email'] = $user->email;
                    $userData['type'] = $user->type;

                    $response['token'] = $token->plainTextToken;
                    $response['user'] = $userData;
                    $response['status'] = 200;

                } else {
                    $response['message'] = trans('auth.mpin.mpin_not_valid');
                    $response['status'] = 401;
                }
            } else {
                $response['message'] = trans('auth.mpin.mpin_not_valid');
                $response['status'] = 401;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['message'] = trans('auth.something_went_wrong');
            $response['status'] = 401;
        }
        return $response;
    }

    /**
     * @return array
     * @since 2020-06-08
     *
     * Logout User.
     *
     * @author Jaynil Parekh
     * @since 2020-06-11
     */
    public function logoutUser()
    {
        $response = [];

        try {

            $user = loggedInUser();

            if (!empty($user)) {
                $user->tokens()->delete();
                $response['message'] = trans('auth.logout_success');
                $response['status'] = 200;
            }

        } catch (\Exception $ex) {
            Log::error($ex);
            $response['message'] = trans('auth.something_went_wrong');
            $response['status'] = 401;
        }
        return $response;
    }

    /**
     * @param array $data
     * @return mixed
     * @author Jaynil Parekh
     * @since 2020-06-08
     *
     * Store user and send verification email.
     *
     */
    public function createUser(array $data)
    {
        try {
            $userData['email'] = $data['email'] ?? null;
            $userData['name'] = $data['name'] ?? null;
            $userData['mobile'] = $data['mobile'] ?? null;
            $userData['password'] = bcrypt($data['password']) ?? null;
            $userData['type'] = bcrypt($data['type']);
            $userData['username'] = generateUsername($data['name']);

            if ($user = $this->model->create($userData)) {
                $user->assignRole('user');
                $otp = generateOtp();

                $dataConfirmationCode['user_id'] = $user->id;
                $dataConfirmationCode['meta_key'] = 'confirmation_code';
                $dataConfirmationCode['meta_value'] = bcrypt($otp);

                $dataRegister['user_id'] = $user->id;
                $dataRegister['meta_key'] = 'registered_from';
                $dataRegister['meta_value'] = 'Mobile';

                $dataRegisterOs['user_id'] = $user->id;
                $dataRegisterOs['meta_key'] = 'registered_os';
                $dataRegisterOs['meta_value'] = 'Android';

                $dataRegisterWith['user_id'] = $user->id;
                $dataRegisterWith['meta_key'] = 'registered_with';
                $dataRegisterWith['meta_value'] = 'Normal';

                //Adding details to user meta
                addUserMultipleMetaValue([$dataConfirmationCode, $dataRegister, $dataRegisterOs, $dataRegisterWith]);

                //event for sending mail of email verification
                event(new \App\Events\Frontend\Auth\UserConfirmation($user, $otp));

                //User detail
                $userDetail['id'] = $user->id;
                $userDetail['name'] = $user->name;
                $userDetail['email'] = $user->email;
                $userDetail['type'] = $user->type;

                $responseData['user'] = $userDetail;
                $responseData['message'] = trans('auth.registration_success');
                $responseData['status'] = 200;
            } else {
                $responseData['message'] = trans('auth.something_went_wrong');
                $responseData['status'] = 403;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $responseData['message'] = trans('auth.something_went_wrong');
            $responseData['status'] = 403;
        }

        return $responseData;
    }

    /**
     *
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-16
     *
     * Check OTP For Email verification.
     *
     */
    public function confirmOtp(array $data)
    {
        $response = [];

        try {
            $user = $this->findByEmail($data['email']);

            $originalOtp = getUserMetaValue($user->id, 'confirmation_code');

            if ($user && !empty($originalOtp) && Hash::check($data['otp'], $originalOtp)) {

                $user->verification_confirmed = 2;
                $user->save();

                removeUserMetaValue($user->id, 'confirmation_code');//Remove confirmation code
                addUserSingleMetaValue($user->id, 'confirmed_at', Carbon::now()->format('Y-m-d H:i:s'));//Adding confirmation time&date

                event(new \App\Events\Frontend\Auth\UserWelcome($user));//Sending welcome mail after confirmation
                //Creating token for authentication
                $token = $user->createToken('app-token');

                $userDetail['id'] = $user->id;
                $userDetail['name'] = $user->name;
                $userDetail['email'] = $user->email;
                $userDetail['type'] = $user->type;

                $response['token'] = $token->plainTextToken;
                $response['user'] = $userDetail;
                $response['status'] = 200;
                $response['message'] = trans('auth.otp.verification_success');
                $response['success'] = true;
            } else {
                $response['status'] = 401;
                $response['message'] = trans('auth.otp.invalid');
                $response['success'] = false;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['status'] = 403;
            $response['message'] = trans('auth.something_went_wrong');
            $response['success'] = false;
        }
        return $response;
    }

    /**
     *
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-17
     *
     * Resend OTP For Email verification.
     *
     */
    public function resendOtp(array $data)
    {
        $response = [];

        try {
            $user = $this->findByEmail($data['email']);

            $otp = generateOtp();

            //event for sending mail of email verification
            event(new \App\Events\Frontend\Auth\UserConfirmation($user, $otp));

            //Update confirmation code with new generated code
            updateUserMetaValue($user->id, 'confirmation_code', bcrypt($otp));

            $response['status'] = 200;
            $response['message'] = trans('auth.otp.sent_success');
            $response['success'] = true;

        } catch (\Exception $ex) {
            Log::error($ex);
            $response['status'] = 403;
            $response['message'] = trans('auth.something_went_wrong');
            $response['success'] = false;
        }
        return $response;
    }

    /**
     *
     * @param array $data
     * @param $provider
     * @return bool
     * @since 2020-06-08
     *
     * Social media login and adding user.
     *
     * @author Jaynil Parekh
     */
    public function findOrCreateSocial(array $data)
    {

        $responseData = [];

        try {

            if (env('SOCIAL_MEDIA_AUTH')) { //if social media login allows

                $provider = $data['provider'];

                // User email may not provided.
                $user_email = $data['email'] ?: "{$data['id']}@{$provider}.com";

                // Check to see if there is a user with this email first.
                $account = $this->userSocialLogin->where('provider', $provider)
                    ->where('provider_id', $data['id'])
                    ->first();

                //If already added in our system it will return values
                if ($account) {
                    $user = $account->user;

                    $token = $user->createToken('app-token');

                    $userData['id'] = $user->id;
                    $userData['name'] = $user->name;
                    $userData['email'] = $user->email;
                    $userData['username'] = $user->username;
                    $userData['type'] = $user->type;
                } else { // Insert as new user
                    $user = $this->findByEmail($data['email']);

                    //Checking email is registered or not if not then save it
                    if (!$user) {
                        $user = $this->model->create([
                            'email' => $user_email,
                            'name' => $data['name'],
                            'username' => generateUsername($data['name']),
                            'type' => $data['type'],
                            'email_verified_at' => date('Y-m-d H:i:s'),
                        ])->assignRole('user');

                        $dataRegister['user_id'] = $user->id;
                        $dataRegister['meta_key'] = 'registered_from';
                        $dataRegister['meta_value'] = 'Social media';

                        $dataRegisterOs['user_id'] = $user->id;
                        $dataRegisterOs['meta_key'] = 'registered_os';
                        $dataRegisterOs['meta_value'] = 'Android';

                        $dataRegisterWith['user_id'] = $user->id;
                        $dataRegisterWith['meta_key'] = 'registered_with';
                        $dataRegisterWith['meta_value'] = $provider;

                        //Adding details to user meta
                        addUserMultipleMetaValue([$dataRegister, $dataRegisterOs, $dataRegisterWith]);
                    }

                    //Store social media account id and provider
                    $user->userSocialLogins()->create([
                        'provider_id' => $data['id'],
                        'provider' => $provider,
                    ]);

                    //deleting previous generated tokens
                    if (!empty($user)) {
                        $user->tokens()->delete();
                    }

                    //Generating new token
                    $token = $user->createToken('app-token');

                    $userData['id'] = $user->id;
                    $userData['name'] = $user->name;
                    $userData['email'] = $user->email;
                    $userData['username'] = $user->username;
                    $userData['type'] = $user->type;
                }

                $responseData['token'] = $token->plainTextToken;
                $responseData['user'] = $userData;
                $responseData['message'] = trans('auth.social_media.login_success', ['provider' => $provider]);
                $responseData['status'] = 200;

            } else {
                $responseData['message'] = trans('auth.social_media.not_allowed');
                $responseData['status'] = 403;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $responseData['message'] = trans('auth.something_went_wrong');
            $responseData['status'] = 403;
        }
        return $responseData;
    }

    /**
     *
     * @return array
     * @since 2020-06-08
     *
     * Get User details.
     *
     * @author Jaynil Parekh
     */
    public function getUserDetail()
    {
        $response = [];

        try {
            $user = loggedInUser();

            //Logged in user details array
            if ($user) {
                $data['id'] = $user->id;
                $data['name'] = $user->name;
                $data['email'] = $user->email;
                $data['type'] = $user->type;

                $response['user'] = $data;
                $response['status'] = 200;
            } else {
                $response['user'] = [];
                $response['status'] = 401;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['message'] = trans('auth.something_went_wrong');
            $response['status'] = 403;
        }

        return $response;
    }

    /**
     *
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-08
     *
     * Change password.
     *
     */
    public function changePassword(array $data)
    {
        $response = [];

        try {

            $user = loggedInUser();

            $currentPassword = isset($data['current_password']) ? $data['current_password'] : '';

            //Checking current password if password is not valid will return error message else if reset with new password
            if (isset($currentPassword) && $currentPassword != '' && !Hash::check($data['current_password'], $user->password)) {
                $response['status'] = 401;
                $response['message'] = trans('auth.change_password.current_pwd_not_matched');
            } elseif (isset($data['password'])) {
                $user->password = bcrypt($data['password']);

                if ($user->save()) {

                    //event for sending mail of email verification
                    event(new \App\Events\Frontend\Auth\UserChangePassword($user));

                    $response['status'] = 200;
                    $response['message'] = trans('auth.change_password.update_success');
                }
            } else {
                $response['status'] = 403;
                $response['message'] = trans('auth.something_went_wrong');
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['status'] = 403;
            $response['message'] = trans('auth.something_went_wrong');
        }
        return $response;
    }

    /**
     *
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-08
     *
     * Set four digit password.
     *
     */
    public function setMpin(array $data)
    {
        $response = [];

        try {
            $user = loggedInUser();

            //Check user available or not
            if ($user) {

                //Save mpin
                addUserSingleMetaValue($user->id, 'mpin', bcrypt($data['mpin']));

                $response['status'] = 200;
                $response['message'] = trans('auth.mpin.mpin_generate_success');
            } else {
                $response['status'] = 400;
                $response['message'] = trans('auth.something_went_wrong');
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['status'] = 403;
            $response['message'] = trans('auth.something_went_wrong');
        }

        return $response;
    }

    /**
     *
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-08
     *
     * Change four digit password.
     *
     */
    public function changeMpin(array $data)
    {
        $response = [];

        try {
            $user = loggedInUser();

            //Check user available or not
            if ($user) {

                $mPin = getUserMetaValue($user->id, 'mpin');

                //Check old mpin
                if (!empty($mPin) && Hash::check($data['old_mpin'], $mPin)) {

                    //Update new mpin
                    updateUserMetaValue($user->id, 'mpin', bcrypt($data['mpin']));

                    //event for sending mail of password reset confirmation
                    event(new \App\Events\Frontend\Auth\UserChangePin($user));

                    $response['status'] = 200;
                    $response['message'] = trans('auth.mpin.mpin_update_success');
                } else {
                    $response['status'] = 401;
                    $response['message'] = trans('auth.mpin.old_mpin_wrong');
                }
            } else {
                $response['status'] = 400;
                $response['message'] = trans('auth.something_went_wrong');
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['status'] = 403;
            $response['message'] = trans('auth.something_went_wrong');
        }
        return $response;
    }

    /**
     *
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-10
     *
     * Send OTP for Forgot password.
     *
     */
    public function sendOtpForForgotPassword(array $data)
    {

        $response = [];

        try {
            $user = $this->findByEmail($data['email']);

            //Check user available or not
            if ($user) {

                $oldOtp = getUserMetaValue($user->id, 'forgot_password_otp');

                $otp = generateOtp();

                //Send otp to user's email
                dispatch(new SendForgotPasswordOtp($user, $otp));

                //Check if otp is available in our data or not
                if ($oldOtp) {

                    //Update old OTP
                    updateUserMetaValue($user->id, 'forgot_password_otp', bcrypt($otp));
                } else {

                    //Add OTP
                    addUserSingleMetaValue($user->id, 'forgot_password_otp', bcrypt($otp));
                }
                $response['status'] = 200;
                $response['message'] = trans('auth.forgot_password.opt_sent_to_email');
                $response['success'] = true;
            } else {
                $response['status'] = 400;
                $response['message'] = trans('auth.something_went_wrong');
                $response['success'] = false;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['status'] = 403;
            $response['message'] = trans('auth.something_went_wrong');
            $response['success'] = false;
        }

        return $response;
    }

    /**
     *
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-10
     *
     * Check OTP For Forgot Password.
     *
     */
    public function confirmOtpForForgotPassword(array $data)
    {
        $response = [];

        try {
            $user = $this->findByEmail($data['email']);

            $originalOtp = getUserMetaValue($user->id, 'forgot_password_otp');

            if ($user && !empty($originalOtp) && Hash::check($data['otp'], $originalOtp)) {

                removeUserMetaValue($user->id, 'forgot_password_otp');

                $response['status'] = 200;
                $response['message'] = trans('auth.forgot_password.otp_verification_successful');
                $response['success'] = true;
            } else {
                $response['status'] = 401;
                $response['message'] = trans('auth.forgot_password.invalid_otp');
                $response['success'] = false;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['status'] = 403;
            $response['message'] = trans('auth.something_went_wrong');
            $response['success'] = false;
        }
        return $response;
    }

    /**
     *
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-10
     *
     * Reset Password.
     *
     */
    public function resetPassword(array $data)
    {
        $response = [];

        try {
            $user = $this->findByEmail($data['email']);

            if ($user) {

                $user->password = bcrypt($data['password']);

                if ($user->save()) {

                    //event for sending mail of password reset confirmation
                    event(new \App\Events\Frontend\Auth\UserChangePassword($user));

                    $response['status'] = 200;
                    $response['message'] = trans('auth.forgot_password.reset_password_successful');
                    $response['success'] = true;
                } else {
                    $response['status'] = 401;
                    $response['message'] = trans('auth.forgot_password.reset_password_failed');
                    $response['success'] = false;
                }
            } else {
                $response['status'] = 401;
                $response['message'] = trans('auth.forgot_password.reset_password_failed');
                $response['success'] = false;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['status'] = 403;
            $response['message'] = trans('auth.something_went_wrong');
            $response['success'] = false;
        }
        return $response;
    }

    /**
     *
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-22
     *
     * Forgot Password.
     *
     */
    public function forgotMpin(array $data)
    {
        $response = [];

        try {
            $user = $this->findByEmail($data['email']);

            if ($user) {

                $otp = generateOtp();

                $availableForgotPinCode = getUserMetaValue($user->id, 'forgot_pin_code');

                if (empty($availableForgotPinCode)) {
                    //Adding details to user meta
                    addUserSingleMetaValue($user->id, 'forgot_pin_code', bcrypt($otp));
                } else {
                    //Update otp of four digit pin confirmation
                    updateUserMetaValue($user->id, 'forgot_pin_code', bcrypt($otp));
                }

                //event for sending mail of email verification
                event(new \App\Events\Frontend\Auth\UserForgotPin($user, $otp));

                $response['status'] = 200;
                $response['message'] = trans('auth.forgot_mpin.otp_sent_successful');
                $response['success'] = true;
            } else {
                $response['status'] = 401;
                $response['message'] = trans('auth.forgot_password.reset_password_failed');
                $response['success'] = false;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['status'] = 403;
            $response['message'] = trans('auth.something_went_wrong');
            $response['success'] = false;
        }
        return $response;
    }

    /**
     *
     * @param array $data
     * @return array
     * @author Jaynil Parekh
     * @since 2020-06-22
     *
     * Reset four digit pin.
     *
     */
    public function resetMpin(array $data)
    {
        $response = [];

        try {

            $user = $this->findByEmail($data['email']);
            $originalOtp = getUserMetaValue($user->id, 'forgot_pin_code');

            //Check user available or not
            if ($user && !empty($originalOtp) && Hash::check($data['otp'], $originalOtp)) {

                removeUserMetaValue($user->id, 'forgot_pin_code');

                //Update pin
                updateUserMetaValue($user->id, 'mpin', bcrypt($data['mpin']));

                //event for sending mail of password reset confirmation
                event(new \App\Events\Frontend\Auth\UserChangePin($user));

                $response['status'] = 200;
                $response['message'] = trans('auth.forgot_mpin.mpin_update_success');
            } else {
                $response['status'] = 400;
                $response['message'] = trans('auth.forgot_mpin.invalid_otp');
            }
        } catch (\Exception $ex) {
            dd($ex);
            Log::error($ex);
            $response['status'] = 403;
            $response['message'] = trans('auth.reset_pin_failed');
        }

        return $response;
    }
}
