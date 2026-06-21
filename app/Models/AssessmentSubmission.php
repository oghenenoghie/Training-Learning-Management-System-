<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AssessmentSubmission extends Model {
    protected $fillable = ['assessment_id', 'user_id', 'answers', 'score', 'passed', 'attempt_number', 'submitted_at'];
    protected $casts = ['answers' => 'array', 'passed' => 'boolean', 'submitted_at' => 'datetime'];
    public function assessment() { return $this->belongsTo(Assessment::class); }
    public function user() { return $this->belongsTo(User::class); }
}
