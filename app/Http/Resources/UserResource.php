<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class UserResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
            'organisation' => $this->organisation,
            'job_title' => $this->job_title,
            'avatar' => $this->avatar,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
        ];
    }
}
