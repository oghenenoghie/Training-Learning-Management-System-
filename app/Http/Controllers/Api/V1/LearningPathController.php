<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\LearningPath;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LearningPathController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $paths = LearningPath::with('courses')->where('is_published', true)->get();
        return $this->success($paths, 'Learning paths');
    }

    public function show($slug)
    {
        $path = LearningPath::with('courses')->where('slug', $slug)->firstOrFail();
        return $this->success($path, 'Learning path detail');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:learning_paths,slug',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric|min:0',
            'is_published'=> 'nullable|boolean',
            'course_ids'  => 'nullable|array',
            'course_ids.*'=> 'exists:courses,id',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $courseIds = $data['course_ids'] ?? [];
        unset($data['course_ids']);

        $path = LearningPath::create($data);

        if ($courseIds) {
            $sync = [];
            foreach ($courseIds as $i => $id) {
                $sync[$id] = ['order' => $i + 1];
            }
            $path->courses()->sync($sync);
        }

        return $this->success($path->load('courses'), 'Learning path created', 201);
    }

    public function update(Request $request, LearningPath $learningPath)
    {
        $data = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'slug'        => 'sometimes|string|max:255|unique:learning_paths,slug,' . $learningPath->id,
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric|min:0',
            'is_published'=> 'nullable|boolean',
            'course_ids'  => 'nullable|array',
            'course_ids.*'=> 'exists:courses,id',
        ]);

        $courseIds = $data['course_ids'] ?? null;
        unset($data['course_ids']);

        $learningPath->update($data);

        if ($courseIds !== null) {
            $sync = [];
            foreach ($courseIds as $i => $id) {
                $sync[$id] = ['order' => $i + 1];
            }
            $learningPath->courses()->sync($sync);
        }

        return $this->success($learningPath->load('courses'), 'Learning path updated');
    }

    public function destroy(LearningPath $learningPath)
    {
        $learningPath->courses()->detach();
        $learningPath->delete();
        return $this->success(null, 'Learning path deleted');
    }
}
