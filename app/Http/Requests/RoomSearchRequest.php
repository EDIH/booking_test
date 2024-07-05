<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'price' => 'numeric|between:0,999999.99',
            'bedrooms' => 'integer|between:1,100',
            'bathrooms' => 'integer|between:1,100',
            'storeys' => 'integer|between:1,100',
            'garages' => 'integer|between:1,100',
        ];
    }
}
