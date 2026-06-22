<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')
            ->withCount('enrolments')
            ->latest()
            ->paginate(20);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'nullable|exists:categories,id',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price'             => 'required|numeric|min:0',
            'duration_days'     => 'required|integer|min:1',
            'mode'              => 'required|in:virtual,in_person,hybrid',
            'level'             => 'nullable|in:beginner,intermediate,advanced',
            'max_delegates'     => 'nullable|integer|min:1',
            'is_published'      => 'nullable|boolean',
            'is_featured'       => 'nullable|boolean',
        ]);

        $data['slug']         = Str::slug($data['title']).'-'.Str::random(4);
        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured']  = $request->boolean('is_featured');

        Course::create($data);

        return redirect('/admin/courses')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'nullable|exists:categories,id',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price'             => 'required|numeric|min:0',
            'duration_days'     => 'required|integer|min:1',
            'mode'              => 'required|in:virtual,in_person,hybrid',
            'level'             => 'nullable|in:beginner,intermediate,advanced',
            'max_delegates'     => 'nullable|integer|min:1',
            'is_published'      => 'nullable|boolean',
            'is_featured'       => 'nullable|boolean',
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured']  = $request->boolean('is_featured');

        $course->update($data);

        return redirect('/admin/courses')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect('/admin/courses')->with('success', 'Course deleted.');
    }
}
