<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class GuestCheckoutRequest extends FormRequest
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
            'name'              => 'required|string',
            'phone'             => 'required',
            'address'           => 'required|string',
            'city_id'           => 'required',
            'status'            => 'new',
            'books'             => 'required|array|min:1',
            'books.*.id'        => 'required|integer|exists:books,id',
            'books.*.quantity'  => 'required|integer|min:1',
        ];
    }
}
