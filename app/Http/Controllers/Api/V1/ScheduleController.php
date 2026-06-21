<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CourseSchedule;
use App\Models\Course;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = CourseSchedule::with('course');
        if ($request->course_id) $query->where('course_id', $request->course_id);
        if ($request->status)    $query->where('status', $request->status);
        if ($request->boolean('upcoming')) $query->where('start_date', '>=', now()->toDateString());
        return $this->success($query->orderBy('start_date')->paginate(15));
    }

    public function show(CourseSchedule $schedule) { return $this->success($schedule->load('course')); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'venue' => 'nullable|string',
            'mode' => 'nullable|in:virtual,in_person,hybrid',
            'max_delegates' => 'nullable|integer|min:1',
            'status' => 'nullable|in:open,closed,cancelled',
        ]);
        $schedule = CourseSchedule::create($data);
        return $this->success($schedule, 'Schedule created', 201);
    }

    public function update(Request $request, CourseSchedule $schedule)
    {
        $data = $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'venue' => 'nullable|string',
            'mode' => 'nullable|in:virtual,in_person,hybrid',
            'max_delegates' => 'nullable|integer',
            'status' => 'nullable|in:open,closed,cancelled',
        ]);
        $schedule->update($data);
        return $this->success($schedule, 'Schedule updated');
    }

    public function destroy(CourseSchedule $schedule) { $schedule->delete(); return $this->success(null, 'Schedule deleted'); }
}
