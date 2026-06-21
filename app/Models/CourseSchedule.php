<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CourseSchedule extends Model {
    protected $fillable = ['course_id', 'start_date', 'end_date', 'venue', 'mode', 'max_delegates', 'status'];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];
    public function course() { return $this->belongsTo(Course::class); }
    public function enrolments() { return $this->hasMany(Enrolment::class, 'schedule_id'); }
}
