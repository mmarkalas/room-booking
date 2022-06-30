<?php

namespace App\Rules\Booking;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Str;

class WithinDuration implements InvokableRule
{
    private $requestKey;

    public function __construct(string $requestKey)
    {
        $this->requestKey = $requestKey;
    }

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
        $againstDate = Carbon::parse(request($this->requestKey));

        $diffInMins = $thisDate->diffInMinutes($againstDate);

        if (
            in_array(
                $diffInMins,
                config('room-booking.durations')
            )
        ) {
            return;
        }

        $requestKeyString =  Str::swap(['_' => ' ',], $this->requestKey);

        $fail("The :attribute and $requestKeyString is more/less than the allowed duration.");
    }
}
