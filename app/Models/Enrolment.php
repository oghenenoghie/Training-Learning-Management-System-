<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Enrolment extends Model {
    protected $fillable = ['user_id', 'course_id', 'schedule_id', 'status', 'enrolled_at', 'completed_at', 'progress'];
    protected $casts = ['enrolled_at' => 'datetime', 'completed_at' => 'datetime', 'progress' => 'integer'];
    public function user() { return $this->belongsTo(User::class); }
    public function course() { return $this->belongsTo(Course::class); }
    public function schedule() { return $this->belongsTo(CourseSchedule::class); }
    public function payment() { return $this->hasOne(Payment::class); }
    public function certificate() { return $this->hasOne(Certificate::class); }
}
