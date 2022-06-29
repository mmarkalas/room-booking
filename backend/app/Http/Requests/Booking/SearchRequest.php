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
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'room' => 'nullable|exists:rooms',
            'user' => 'nullable|exists:users',
            'page' => 'nullable|numeric',
            'limit' => 'nullable|numeric',
        ];
    }
}
