<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
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

    public function search(
        array $request,
        $getCollection = false,
        $exactTime = false
    ) {
        $query = $this->model
            ->when(
                isset($request['except']) ? $request['except'] : false,
                function ($query, $id) {
                    $query->activeBooking($id);
                }
            )
            ->when(
                isset($request['search']) ? $request['search'] : false,
                function ($query, $searchString) {
                    $query
                        ->whereHas('room', function ($q) use ($searchString) {
                            $q->whereFullText('name', $searchString);
                        })
                        ->orWhereHas('user', function ($q) use ($searchString) {
                            $q->whereFullText('name', $searchString);
                        });
                }
            )
            ->when(
                isset($request['room_id']) ? $request['room_id'] : false,
                function ($query, $room) {
                    $query->where('room_id', $room);
                }
            )
            ->when(
                isset($request['user_id']) ? $request['user_id'] : false,
                function ($query, $user) {
                    $query->where('user_id', $user);
                }
            )
            ->when(
                isset($request['from_date']) || isset($request['to_date']),
                function ($query, $date) use ($request, $exactTime) {
                    $fromDate = Carbon::parse(
                        isset($request['from_date'])
                            ? $request['from_date']
                            : null
                    );

                    $toDate = Carbon::parse(
                        isset($request['to_date'])
                            ? $request['to_date']
                            : null
                    );

                    $startDate = $fromDate->copy();
                    $endDate = $toDate->copy();

                    if (!$exactTime) {
                        $startDate->startOfDay();
                        $endDate->endOfDay();
                    }

                    $query
                        ->where(function ($innerQuery) use ($startDate, $endDate) {
                            $innerQuery->where(function ($q) use ($startDate, $endDate) {
                                $q->where('from_date', '>=', $startDate)
                                    ->where('from_date', '<=', $endDate);
                            })
                            ->orWhere(function ($q) use ($startDate, $endDate) {
                                $q->where('to_date', '>', $startDate)
                                    ->where('to_date', '<=', $endDate);
                            });
                        });
                }
            )
            ->when(
                isset($request['sort']) ? $request['sort'] : false,
                function ($query, $sortString) {
                    $sortArray = explode(',', $sortString);

                    foreach ($sortArray as $key => $sortItem) {
                        $item = explode(':', $sortItem);

                        if ($item[0] == 'room') {
                            if ($item[1] == 'asc') {
                                $query->orderBy(
                                    Room::select('name')
                                        ->whereColumn('id', $this->model->getTable() . '.id')
                                        ->orderBy('name')
                                        ->limit(1)
                                );
                            } else {
                                $query->orderByDesc(
                                    Room::select('name')
                                        ->whereColumn('id', $this->model->getTable() . '.id')
                                        ->orderByDesc('name')
                                        ->limit(1)
                                );
                            }
                        } elseif ($item[0] == 'user') {
                            if ($item[1] == 'asc') {
                                $query->orderBy(
                                    User::select('name')
                                        ->whereColumn('id', $this->model->getTable() . '.id')
                                        ->orderBy('name')
                                        ->limit(1)
                                );
                            } else {
                                $query->orderByDesc(
                                    User::select('name')
                                        ->whereColumn('id', $this->model->getTable() . '.id')
                                        ->orderByDesc('name')
                                        ->limit(1)
                                );
                            }
                        } else {
                            $query->orderBy($item[0], $item[1]);
                        }
                    }
                }
            );

        $limit = isset($request['limit'])
            ? $request['limit']
            : self::DEFAULT_LIMIT;

        return $getCollection
            ? $query->get()
            : $query->paginate($limit);
    }
}
