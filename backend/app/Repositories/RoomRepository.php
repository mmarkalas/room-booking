<?php

namespace App\Repositories;

use App\Models\Room;

class RoomRepository extends BaseRepository
{
    /**
     * Set Model Property
     *
     * @return void
     */
    public function setModel()
    {
        $this->model = new Room();
    }
}
