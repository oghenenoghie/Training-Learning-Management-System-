<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Course extends Model {
    use SoftDeletes;
    protected $fillable = [
        'category_id', 'title', 'slug', 'description', 'short_description',
        'price', 'duration_days', 'mode', 'level', 'thumbnail',
        'is_published', 'is_featured', 'max_delegates',
    ];
    protected $casts = [
        'price' => 'decimal:2',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];
    public function category() { return $this->belongsTo(Category::class); }
    public function schedules() { return $this->hasMany(CourseSchedule::class); }
    public function enrolments() { return $this->hasMany(Enrolment::class); }
    public function materials() { return $this->hasMany(CourseMaterial::class)->orderBy('order'); }
    public function assessments() { return $this->hasMany(Assessment::class); }
    public function learningPaths() { return $this->belongsToMany(LearningPath::class, 'learning_path_course')->withPivot('order'); }
}
