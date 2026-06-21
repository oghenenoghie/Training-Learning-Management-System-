<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
    protected $fillable = ['user_id', 'enrolment_id', 'amount', 'currency', 'reference', 'gateway', 'status', 'paid_at', 'invoice_number', 'vat_amount'];
    protected $casts = ['amount' => 'decimal:2', 'vat_amount' => 'decimal:2', 'paid_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function enrolment() { return $this->belongsTo(Enrolment::class); }
}
