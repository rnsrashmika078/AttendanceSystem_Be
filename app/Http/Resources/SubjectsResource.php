<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectsResource extends JsonResource
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
            'semester' => $this->semester,
            'year' => $this->year,
            'user_id' => $this->user_id,
            'subject_code' => $this->subject_code,
            'subject' => $this->subject,
            'lecturer' => $this->lecturer,

            'users' => $this->users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->pivot->role
                ];
            })
        ];
    }
}
