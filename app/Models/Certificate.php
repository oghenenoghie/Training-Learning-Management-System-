<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Certificate extends Model {
    protected $fillable = ['user_id', 'course_id', 'enrolment_id', 'certificate_number', 'issued_at', 'verification_code'];
    protected $casts = ['issued_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function course() { return $this->belongsTo(Course::class); }
    public function enrolment() { return $this->belongsTo(Enrolment::class); }
}
