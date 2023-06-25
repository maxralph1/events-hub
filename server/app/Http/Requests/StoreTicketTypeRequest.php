<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketTypeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'event_id' => 'required',
            'title' => 'required|unique:ticket_types|max:155',
            'description' => 'required|max:255',
            'available_tickets' => 'required|numeric',
            'price' => 'required',
            'currency_id' => 'required',
        ];
    }
}
