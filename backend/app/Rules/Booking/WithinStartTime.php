<?php

namespace App\Rules\Booking;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\InvokableRule;

class WithinStartTime implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $thisDate = Carbon::parse($value);

        $startTimeArray = explode(':', config('room-booking.timeframe.start'));
        $endTimeArray = explode(':', config('room-booking.timeframe.end'));

        $startTime = $thisDate->copy()->setTime(...$startTimeArray);
        $endTime = $thisDate->copy()->setTime(...$endTimeArray);

        if (
            !($thisDate->gte($startTime) && $thisDate->lte($endTime))
        ) {
            $startString = $startTime->format('g:iA');
            $endString = $endTime->format('g:iA');
            $fail(
                "The :attribute is not within the $startString - $endString schedule."
            );
        }
    }
}
