<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
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
            'Number' => $this->Number,
            'chair_number' => $this->chair_number,
            'Is_available' => $this->Is_available,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];;
    }
}
