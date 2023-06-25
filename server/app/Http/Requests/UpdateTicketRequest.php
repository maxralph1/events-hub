<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
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
            'event_id' => 'nullable',
            'ticket_type_id' => 'nullable',
            'user_id' => 'nullable',
            'amount_paid' => 'nullable',
            'currency_id' => 'nullable',
            'payment_confirmed' => 'nullable|boolean',
        ];
    }
}
