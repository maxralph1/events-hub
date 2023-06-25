<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketTypeResource extends JsonResource
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
            'event' => [
                'id' => $this->event->id,
                'name' => $this->event->name,
                'description' => $this->event->description,
            ],
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'available_tickets' => $this->available_tickets,
            'price' => $this->amount_paid,
            'currency' => [
                'id' => $this->currency->id,
                'name' => $this->currency->name,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
