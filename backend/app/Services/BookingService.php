<?php

namespace App\Services;

use App\Repositories\BookingRepository;

class BookingService extends BaseService
{
    /**
     * Set Repo Property
     *
     * @return void
     */
    public function setRepo()
    {
        $this->repo = new BookingRepository();
    }

    public function search(array $request)
    {
        return $this->repo->search($request);
    }

    public function processBooking(array $request)
    {
        return $this->repo->search($request);
    }
}
