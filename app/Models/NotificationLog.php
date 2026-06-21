<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class NotificationLog extends Model {
    protected $table = 'notifications_log';
    protected $fillable = ['user_id', 'type', 'subject', 'body', 'sent_at', 'channel'];
    protected $casts = ['sent_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
}
