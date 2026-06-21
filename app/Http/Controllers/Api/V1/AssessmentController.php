<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentSubmission;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Assessment::with('course');
        if ($request->course_id) $query->where('course_id', $request->course_id);
        return $this->success($query->get());
    }

    public function show(Assessment $assessment)
    {
        return $this->success($assessment->load(['questions', 'course']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'type' => 'required|in:mcq,short_answer,file_upload',
            'pass_score' => 'nullable|integer|min:0|max:100',
            'max_attempts' => 'nullable|integer|min:1',
        ]);
        $assessment = Assessment::create($data);
        return $this->success($assessment, 'Assessment created', 201);
    }

    public function update(Request $request, Assessment $assessment)
    {
        $data = $request->validate([
            'title' => 'sometimes|string',
            'type' => 'sometimes|in:mcq,short_answer,file_upload',
            'pass_score' => 'nullable|integer',
            'max_attempts' => 'nullable|integer',
        ]);
        $assessment->update($data);
        return $this->success($assessment, 'Assessment updated');
    }

    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return $this->success(null, 'Assessment deleted');
    }

    public function submit(Request $request, Assessment $assessment)
    {
        $request->validate(['answers' => 'required|array']);
        $attempts = AssessmentSubmission::where('assessment_id', $assessment->id)
            ->where('user_id', $request->user()->id)->count();
        if ($attempts >= $assessment->max_attempts) {
            return $this->error('Maximum attempts reached', 422);
        }
        // Calculate score for MCQ
        $score = 0;
        $totalMarks = 0;
        foreach ($assessment->questions as $q) {
            $totalMarks += $q->marks;
            if (isset($request->answers[$q->id]) && $request->answers[$q->id] == $q->correct_answer) {
                $score += $q->marks;
            }
        }
        $percentage = $totalMarks > 0 ? round(($score / $totalMarks) * 100) : 0;
        $passed = $percentage >= $assessment->pass_score;
        $submission = AssessmentSubmission::create([
            'assessment_id' => $assessment->id,
            'user_id' => $request->user()->id,
            'answers' => $request->answers,
            'score' => $percentage,
            'passed' => $passed,
            'attempt_number' => $attempts + 1,
            'submitted_at' => now(),
        ]);
        return $this->success([
            'submission' => $submission,
            'score' => $percentage,
            'passed' => $passed,
        ], $passed ? 'Assessment passed!' : 'Assessment submitted');
    }

    public function results(Request $request, Assessment $assessment)
    {
        $query = AssessmentSubmission::where('assessment_id', $assessment->id);
        if ($request->user()->hasRole('delegate')) {
            $query->where('user_id', $request->user()->id);
        }
        return $this->success($query->with('user')->get());
    }
}
