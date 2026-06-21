<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use App\Models\Course;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CourseMaterialController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $request->validate(['course_id' => 'required|exists:courses,id']);
        $query = CourseMaterial::where('course_id', $request->course_id);

        // Non-admins/non-owners only see free previews
        if (!$request->user() || $request->user()->hasRole('delegate')) {
            // Check enrolment
            $enrolled = $request->user()
                ? \App\Models\Enrolment::where('user_id', $request->user()->id)
                    ->where('course_id', $request->course_id)
                    ->whereIn('status', ['enrolled', 'in_progress', 'completed'])
                    ->exists()
                : false;
            if (!$enrolled) {
                $query->where('is_free_preview', true);
            }
        }

        return $this->success($query->orderBy('order')->get(), 'Course materials');
    }

    public function show(CourseMaterial $material)
    {
        return $this->success($material->load('course'), 'Material detail');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id'       => 'required|exists:courses,id',
            'title'           => 'required|string|max:255',
            'type'            => 'required|in:video,pdf,document',
            'url'             => 'required|string|max:2048',
            'order'           => 'nullable|integer|min:0',
            'is_free_preview' => 'nullable|boolean',
        ]);
        $material = CourseMaterial::create($data);
        return $this->success($material, 'Material created', 201);
    }

    public function update(Request $request, CourseMaterial $material)
    {
        $data = $request->validate([
            'title'           => 'sometimes|string|max:255',
            'type'            => 'sometimes|in:video,pdf,document',
            'url'             => 'sometimes|string|max:2048',
            'order'           => 'nullable|integer|min:0',
            'is_free_preview' => 'nullable|boolean',
        ]);
        $material->update($data);
        return $this->success($material, 'Material updated');
    }

    public function destroy(CourseMaterial $material)
    {
        $material->delete();
        return $this->success(null, 'Material deleted');
    }
}
