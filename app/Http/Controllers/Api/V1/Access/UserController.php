<?php

namespace App\Http\Controllers\Api\V1\Access;

use App\Http\Controllers\Api\APIController;
use App\Repositories\Api\Access\User\UserInterface as UserRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends APIController
{

    /**
     * @param UserRepo $userRepo
     * @since 2020-06-09
     *
     * UserController constructor.
     *
     * @author Jaynil Parekh
     */
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @author Jaynil Parekh
     * @since 2020-06-09
     *
     * Get User Detail.
     *
     */
    public function getUserDetail()
    {
        $response = [];

        try {
            $response = $this->userRepo->getUserDetail();
            $this->setStatusCode($response['status']);
            unset($response['status']);
        } catch (\Exception $ex) {
            Log::error($ex);
            $this->setStatusCode(403);
        }
        return $this->respond($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @author Jaynil Parekh
     * @since 2020-06-09
     *
     * Change password.
     *
     */
    public function changePassword(Request $request)
    {
        $response = [];

        try {

            $validation = Validator::make($request->all(), [
                'current_password' => 'required',
                'password' => 'required|min:6|max:15|confirmed|regex:"^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,15}$"',
            ]);

            if ($validation->fails()) {
                return $this->throwValidation($validation->messages()->first());
            }

            $response = $this->userRepo->changePassword($request->all());
            $this->setStatusCode($response['status']);
            unset($response['status']);
        } catch (\Exception $ex) {
            Log::error($ex);
            $this->setStatusCode(403);
        }
        return $this->respond($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @author Jaynil Parekh
     * @since 2020-06-09
     *
     * Change password.
     *
     */
    public function setMpin(Request $request)
    {
        $response = [];

        try {

            $validation = Validator::make($request->all(), [
                'mpin' => 'required|max:4',
                'confirm_mpin' => 'required|max:4|same:mpin',
            ]);

            if ($validation->fails()) {
                return $this->throwValidation($validation->messages()->first());
            }
            $response = $this->userRepo->setMpin($request->all());
            $this->setStatusCode($response['status']);
            unset($response['status']);
        } catch (\Exception $ex) {
            Log::error($ex);
            $this->setStatusCode(403);
        }
        return $this->respond($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @author Jaynil Parekh
     * @since 2020-06-09
     *
     * Change Four digit pin.
     *
     */
    public function changeMpin(Request $request)
    {
        $response = [];

        try {

            $validation = Validator::make($request->all(), [
                'old_mpin' => 'required|max:4',
                'mpin' => 'required|max:4',
                'confirm_mpin' => 'required|max:4|same:mpin',
            ]);

            if ($validation->fails()) {
                return $this->throwValidation($validation->messages()->first());
            }

            $response = $this->userRepo->changeMpin($request->all());
            $this->setStatusCode($response['status']);
            unset($response['status']);
        } catch (\Exception $ex) {
            Log::error($ex);
            $this->setStatusCode(403);
        }
        return $this->respond($response);
    }
}
