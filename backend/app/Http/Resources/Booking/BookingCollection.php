<?php

namespace App\Http\Resources\Booking;

use App\Http\Resources\BaseCollection;

class BookingCollection extends BaseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!$this->paginate) {
            return parent::toArray($request);
        }

        try {
            return [
                'bookings' => $this->collection,
                'pagination' => [
                    'total' => $this->total(),
                    'count' => $this->count(),
                    'perPage' => (int) $this->perPage(),
                    'currentPage' => $this->currentPage(),
                    'totalPages' => $this->lastPage()
                ],
            ];
        } catch (\Exception $e) {
            $total = $this->collection->count();
            return [
                'developments' => $this->collection,
                'totalDevelopments' => $total,
                'totalProperties' => $this->totalProperties(),
                'pagination' => [
                    'total' => $total,
                ]
            ];
        }
    }
}
