<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')
            ->where('is_published', true)
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        if ($courses->count() < 6) {
            $ids = $courses->pluck('id');
            $extra = Course::with('category')
                ->where('is_published', true)
                ->whereNotIn('id', $ids)
                ->latest()
                ->take(6 - $courses->count())
                ->get();
            $courses = $courses->concat($extra);
        }

        $categories = Category::withCount('courses')->get();

        return view('welcome', compact('courses', 'categories'));
    }
}
