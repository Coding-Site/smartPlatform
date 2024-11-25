<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'gender'    => $this->gender,
            'user_type' => $this->user_type,
            'class'     => $this->class,
            'stage'     => $this->stage,
            "token"     => $this->when(isset($this->token), $this->token),

        ];
    }
}
