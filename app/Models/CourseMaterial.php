<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CourseMaterial extends Model {
    protected $fillable = ['course_id', 'title', 'type', 'url', 'order', 'is_free_preview'];
    protected $casts = ['is_free_preview' => 'boolean'];
    public function course() { return $this->belongsTo(Course::class); }
}
