<?php

namespace App\Http\Resources\Booking;

use App\Http\Resources\Room\RoomResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'room' => new RoomResource($this->room),
            'user' => new UserResource($this->user),
            'from_date' => $this->from_date->toDateTimeString(),
            'to_date' => $this->to_date->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
