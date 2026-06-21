<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AssessmentQuestion extends Model {
    protected $fillable = ['assessment_id', 'question', 'type', 'options', 'correct_answer', 'marks', 'order'];
    protected $casts = ['options' => 'array'];
    public function assessment() { return $this->belongsTo(Assessment::class); }
}
