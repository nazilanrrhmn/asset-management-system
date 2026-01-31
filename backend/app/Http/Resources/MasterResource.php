<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? $this->description,
            'details'    => $this->when(isset($this->changes), $this->changes),
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
        ];
    }
}
