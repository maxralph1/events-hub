<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ticket_number' => $this->ticket_number,
            'event' => [
                'id' => $this->event->id,
                'name' => $this->event->name,
                'description' => $this->event->description,
            ],
            'ticket_type' => [
                'id' => $this->ticket_type->id,
                'name' => $this->ticket_type->name,
                'description' => $this->ticket_type->description,
                // 'price' => $this->ticket_type->price,
            ],
            'added_by' => $this->user_id,
            // 'added_by' => [
            //     'id' => $this->user->id,
            //     'name' => $this->user->name,
            // ],
            'amount_paid' => number_format($this->amount_paid, 2),
            'currency' => [
                'id' => $this->currency->id,
                'name' => $this->currency->name,
            ],
            'payment_confirmed' => $this->payment_confirmed,
            'payment_confirmed_by' => $this->payment_confirmed_by,
            // 'payment_confirmed_by' => [
            //     'id' => $this->user->id,
            //     'name' => $this->user->name,
            // ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
