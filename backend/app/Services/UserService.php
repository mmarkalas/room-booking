<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\User;
use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class UserService extends BaseService
{
    /**
     * Set Repo Property
     *
     * @return void
     */
    public function setRepo()
    {
        $this->repo = new UserRepository();
    }

    public function authenticate(array $request): User
    {
        if (!auth()->attempt($request)) {
            throw new ApiException(
                __('response.unauth'),
                Response::HTTP_UNAUTHORIZED
            );
        }

        return auth()->user();
    }
}
