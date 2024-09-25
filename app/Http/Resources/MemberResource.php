<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
        [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'tel' => $this->tel,
            'email' => $this->email,
            'marital_status' => $this->marital_status,
        ];
    }

}
