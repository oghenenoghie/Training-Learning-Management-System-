<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class CourseResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'price' => $this->price,
            'duration_days' => $this->duration_days,
            'mode' => $this->mode,
            'level' => $this->level,
            'thumbnail' => $this->thumbnail,
            'is_published' => $this->is_published,
            'is_featured' => $this->is_featured,
            'max_delegates' => $this->max_delegates,
            'category' => $this->whenLoaded('category'),
            'schedules' => $this->whenLoaded('schedules'),
            'created_at' => $this->created_at,
        ];
    }
}
