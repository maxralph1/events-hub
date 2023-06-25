<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'ticket_type_id' => 'required',
            'user_id' => 'required',
            'amount_paid' => 'required|numeric',
            'currency_id' => 'required',
            'payment_confirmed' => 'nullable|boolean',
        ];
    }
}
