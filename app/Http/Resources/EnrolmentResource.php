<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class EnrolmentResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'schedule_id' => $this->schedule_id,
            'status' => $this->status,
            'enrolled_at' => $this->enrolled_at,
            'completed_at' => $this->completed_at,
            'progress' => $this->progress,
            'user' => new UserResource($this->whenLoaded('user')),
            'course' => new CourseResource($this->whenLoaded('course')),
            'created_at' => $this->created_at,
        ];
    }
}
