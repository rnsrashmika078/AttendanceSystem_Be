<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionInfoResource extends JsonResource
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
            'lecturer_name' => $this->lecturer_name,
            'lecturer_email' => $this->lecturer_email,
            'course_id' => $this->course_id,
            'lecturer_id' => $this->lecturer_id,
            'session_status' => ($this->session_status === "finished" ? "finished" : now()->greaterThan($this->expires_at)) ? "finished" : "on-progress",
            'started_at' => $this->started_at,
            'expires_at' => $this->expires_at,
            'remain_in_sec' => max(0, now()->diffInSeconds($this->expires_at), false)
        ];
    }
}
// now()->greaterThan($this->expires_at) ? "finished" : "on-progress"