<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * Set Model Property
     *
     * @return void
     */
    public function setModel()
    {
        $this->model = new User();
    }
}
