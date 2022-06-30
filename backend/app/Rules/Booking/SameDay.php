<?php

namespace App\Rules\Booking;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Str;

class SameDay implements InvokableRule
{
    private $requestKey;

    public function __construct(string $requestKey) {
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

        $requestKeyString =  Str::swap(['_' => ' ',], $this->requestKey);

        if(!$thisDate->isSameDay($againstDate)) {
            $fail("The :attribute is not the same day with $requestKeyString.");
        }
    }
}
