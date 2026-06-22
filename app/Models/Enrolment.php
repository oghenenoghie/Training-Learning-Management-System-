<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Enrolment extends Model {
    protected $fillable = [
        'user_id', 'course_id', 'schedule_id', 'status', 'enrolled_at', 'completed_at', 'progress',
        'booker_type', 'company_name', 'contact_person', 'contact_email', 'contact_phone',
        'company_address', 'po_number', 'number_of_delegates', 'delegate_names',
        'payment_method', 'subtotal', 'vat_amount', 'total_amount', 'booking_reference',
    ];
    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress' => 'integer',
        'delegate_names' => 'array',
        'subtotal' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function course() { return $this->belongsTo(Course::class); }
    public function schedule() { return $this->belongsTo(CourseSchedule::class); }
    public function payment() { return $this->hasOne(Payment::class); }
    public function certificate() { return $this->hasOne(Certificate::class); }
}
