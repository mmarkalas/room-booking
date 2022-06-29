<?php

namespace App\Repositories;

use App\Models\Booking;
use Carbon\Carbon;

class BookingRepository extends BaseRepository
{
    /**
     * Set Model Property
     *
     * @return void
     */
    public function setModel()
    {
        $this->model = new Booking();
    }

    public function search(array $request)
    {
        $query = $this->model
            ->when(
                isset($request['room']) ? $request['room'] : false,
                function ($query, $room) {
                    $query->where('room_id', $room);
                }
            )
            ->when(
                isset($request['user']) ? $request['user'] : false,
                function ($query, $user) {
                    $query->where('user_id', $user);
                }
            )
            ->when(
                isset($request['date_from']) ? $request['date_from'] : false,
                function ($query, $date) {
                    $parsedDate = Carbon::parse($date);
                    $startDate = $parsedDate->copy()->startOfDay();
                    $query->where('from_date', $startDate);
                }
            )
            ->when(
                isset($request['date_to']) ? $request['date_to'] : false,
                function ($query, $date) {
                    $parsedDate = Carbon::parse($date);
                    $endDate = $parsedDate->copy()->endOfDay();
                    $query->where('to_date', $endDate);
                }
            );

        $limit = isset($request['limit'])
            ? $request['limit']
            : self::DEFAULT_LIMIT;

        return $query->paginate($limit);
    }
}
