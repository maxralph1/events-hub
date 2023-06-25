<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            // 'user' => $this->added_by_id,
            // 'added_by' => [
            //     'id' => $this->user->id,
            //     'name' => $this->user->name,
            // ],
            // 'event_hall_id' => $this->event_hall_id,
            'event_hall' => [
                'id' => $this->event_hall->id,
                'name' => $this->event_hall->name,
                'description' => $this->event_hall->description,
            ],
            // 'host_id' => $this->host_id,
            'host' => [
                'id' => $this->host->id,
                'name' => $this->host->name,
            ],
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'end_date' => $this->end_date,
            'end_time' => $this->end_time,
            'age_limit' => $this->age_limit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
