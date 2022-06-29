<?php

namespace App\Services;

use App\Repositories\RoomRepository;

class RoomService extends BaseService
{
    /**
     * Set Repo Property
     *
     * @return void
     */
    public function setRepo()
    {
        $this->repo = new RoomRepository();
    }
}
