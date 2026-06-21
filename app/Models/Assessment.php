<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Assessment extends Model {
    protected $fillable = ['course_id', 'title', 'type', 'pass_score', 'max_attempts'];
    public function course() { return $this->belongsTo(Course::class); }
    public function questions() { return $this->hasMany(AssessmentQuestion::class)->orderBy('order'); }
    public function submissions() { return $this->hasMany(AssessmentSubmission::class); }
}
