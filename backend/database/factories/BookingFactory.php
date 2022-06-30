<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = fake()->dateTimeBetween('now', '+4 week');
        $carbonDate = Carbon::parse($date);
        $fromDate = $carbonDate->copy()->setTime(12, 0);
        $toDate = $fromDate->copy()->setTime(13, 0);

        return [
            'room_id' => Room::inRandomOrder()->first(),
            'user_id' => User::inRandomOrder()->first(),
            'from_date' => $fromDate,
            'to_date' => $toDate,
        ];
    }
}
