<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Room Booking Configurations
    |--------------------------------------------------------------------------
    */

    'durations' => explode(',', env('RB_DURATIONS', '30,60')),
    'timeframe' => [
        'start' => env('RB_TIMEFRAME_START', '08:00'),
        'end' => env('RB_TIMEFRAME_END', '17:00')
    ],
];
