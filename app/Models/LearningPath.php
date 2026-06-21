<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LearningPath extends Model {
    protected $fillable = ['title', 'slug', 'description', 'price', 'is_published'];
    protected $casts = ['price' => 'decimal:2', 'is_published' => 'boolean'];
    public function courses() { return $this->belongsToMany(Course::class, 'learning_path_course')->withPivot('order'); }
}
