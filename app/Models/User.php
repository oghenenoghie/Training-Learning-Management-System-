<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone',
        'organisation', 'job_title', 'avatar',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function enrolments() { return $this->hasMany(Enrolment::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function certificates() { return $this->hasMany(Certificate::class); }
    public function submissions() { return $this->hasMany(AssessmentSubmission::class); }
}
