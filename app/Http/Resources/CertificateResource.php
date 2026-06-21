<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class CertificateResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'certificate_number' => $this->certificate_number,
            'verification_code' => $this->verification_code,
            'issued_at' => $this->issued_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'course' => new CourseResource($this->whenLoaded('course')),
            'created_at' => $this->created_at,
        ];
    }
}
