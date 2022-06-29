<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\User\UserResource;
use App\Services\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private $roomService;

    public function __construct(RoomService $roomService) {
        parent::__construct();
        $this->roomService = $roomService;
    }

    public function register(RegistrationRequest $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $user = $this->userService->create($request->validated());

            $accessToken = $user->createToken('authToken')->accessToken;

            return $this->response->setData([
                'user' => new UserResource($user),
                'access_token' => $accessToken
            ]);
        });
    }

    public function login(LoginRequest $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $user = $this->userService->authenticate($request->validated());

            $accessToken = $user->createToken('authToken')->accessToken;

            return $this->response->setData([
                'access_token' => $accessToken
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
