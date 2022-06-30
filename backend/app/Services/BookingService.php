<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Booking;
use App\Repositories\BookingRepository;
use App\Repositories\RoomRepository;
use Symfony\Component\HttpFoundation\Response;

class BookingService extends BaseService
{
    private $roomRepo;

    public function __construct(RoomRepository $roomRepo)
    {
        parent::__construct();
        $this->roomRepo = $roomRepo;
    }

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

    public function createBooking(array $request)
    {
        $existingBookings = $this->repo->search(
            $request,
            getCollection: true,
            exactTime: true,
        );

        if ($existingBookings->count() > 0) {
            $room = $existingBookings->first()->room;

            throw new ApiException(
                "Room $room->name is already booked.",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $storeParams = [
            ...$request,
            'user_id' => auth()->user()->id
        ];

        return $this->repo->create($storeParams);
    }

    public function updateBooking(array $request, Booking $booking)
    {
        $existingBookings = $this->repo
            ->search(
                [
                    ...$request,
                    'except' => $booking->id
                ],
                getCollection: true,
                exactTime: true,
            );

        if ($existingBookings->count() > 0) {
            $room = $existingBookings->first()->room;

            throw new ApiException(
                "Room $room->name is already booked.",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $this->repo->update($booking, $request);
    }
}
