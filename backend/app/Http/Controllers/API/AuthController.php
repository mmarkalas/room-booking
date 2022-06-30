<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function register(RegistrationRequest $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $user = $this->userService->create($request->validated());

            $tokenObj = $user->createToken('authToken');

            return $this->response->setData([
                'user' => new UserResource($user),
                'access_token' => $tokenObj->accessToken,
                'expires_at' => $tokenObj->token->expires_at->timestamp,
            ]);
        });
    }

    public function login(LoginRequest $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $user = $this->userService->authenticate($request->validated());

            $tokenObj = $user->createToken('authToken');

            return $this->response->setData([
                'access_token' => $tokenObj->accessToken,
                'expires_at' => $tokenObj->token->expires_at->timestamp,
            ]);
        });
    }

    public function logout(Request $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $user = $this->userService->getAuthUser();

            $user->token()->revoke();

            return $this->response;
        });
    }
}
