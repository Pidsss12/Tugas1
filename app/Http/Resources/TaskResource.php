<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // 1. JSON:API Standard Formatting
        return [
            'type' => 'tasks',
            'id' => (string) $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->description,
                'subject' => $this->subject,
                'priority' => $this->priority,
                'status' => $this->status,
                'deadline' => $this->deadline,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => url('/api/tasks/' . $this->id),
            ]
        ];
    }
}
