<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'room_id' => 'nullable|exists:rooms',
            'user_id' => 'nullable|exists:users',
            'page' => 'nullable|numeric',
            'limit' => 'nullable|numeric',
            'search' => 'nullable|string',
            'sort' => 'nullable|string',
        ];
    }
}
