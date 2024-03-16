<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\LoginAction;
use App\Actions\Fortify\RegisterAction;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Traits\ApiResponseHelper;

class AuthController extends Controller
{
    use ApiResponseHelper;

    public function Login(LoginRequest $request, LoginAction $action)
    {
        $token = $action->login($request);

        return $this->respondWithSuccess(["token" => $token]);
    }

    public function Register(RegisterRequest $request, RegisterAction $action)
    {
        $token = $action->register($request);

        return $this->respondWithSuccess(["token" => $token]);
    }
}
