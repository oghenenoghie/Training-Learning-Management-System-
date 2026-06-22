<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('category')
            ->where('is_published', true);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('short_description', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('mode')) {
            $query->where('mode', $request->mode);
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('name', 'like', '%'.$request->category.'%'));
        }

        $courses = $query->latest()->paginate(12);

        return view('courses.index', compact('courses'));
    }

    public function show($slug)
    {
        $course = Course::with(['category', 'schedules', 'materials'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $related = Course::with('category')
            ->where('is_published', true)
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->take(3)
            ->get();

        return view('courses.show', compact('course', 'related'));
    }
}
