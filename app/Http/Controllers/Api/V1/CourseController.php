<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Course::with('category')->where('is_published', true);
        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->mode) $query->where('mode', $request->mode);
        if ($request->min_price) $query->where('price', '>=', $request->min_price);
        if ($request->max_price) $query->where('price', '<=', $request->max_price);
        if ($request->search) {
            $query->where(fn($q) => $q->where('title', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%"));
        }
        return $this->success(CourseResource::collection($query->paginate(15)));
    }

    public function show($slug)
    {
        $course = Course::with(['category', 'schedules', 'materials'])->where('slug', $slug)->firstOrFail();
        return $this->success(new CourseResource($course));
    }

    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(6);
        $course = Course::create($data);
        return $this->success(new CourseResource($course), 'Course created', 201);
    }

    public function update(StoreCourseRequest $request, Course $course)
    {
        $course->update($request->validated());
        return $this->success(new CourseResource($course), 'Course updated');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return $this->success(null, 'Course deleted');
    }

    public function publish(Course $course)
    {
        $course->update(['is_published' => !$course->is_published]);
        $msg = $course->is_published ? 'Course published' : 'Course unpublished';
        return $this->success(new CourseResource($course), $msg);
    }

    public function featured(Course $course)
    {
        $course->update(['is_featured' => !$course->is_featured]);
        return $this->success(new CourseResource($course), 'Featured status updated');
    }
}
