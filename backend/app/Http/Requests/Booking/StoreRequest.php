<?php

namespace App\Http\Requests\Booking;

use App\Rules\Booking\SameDay;
use App\Rules\Booking\WithinDuration;
use App\Rules\Booking\WithinStartTime;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'from_date' => [
                'required',
                'date',
                new SameDay('to_date'),
                new WithinStartTime,
                new WithinDuration('to_date'),
            ],
            'to_date' => [
                'required',
                'date',
                new SameDay('from_date'),
            ],
        ];
    }
}
