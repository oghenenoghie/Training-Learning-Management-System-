<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrolmentRequest;
use App\Http\Resources\EnrolmentResource;
use App\Mail\EnrolmentConfirmed;
use App\Models\Enrolment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnrolmentController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Enrolment::with(['user', 'course', 'schedule']);
        // Delegates only see their own
        if ($request->user()->hasRole('delegate')) {
            $query->where('user_id', $request->user()->id);
        }
        if ($request->status) $query->where('status', $request->status);
        if ($request->course_id) $query->where('course_id', $request->course_id);
        if ($request->user_id && !$request->user()->hasRole('delegate')) $query->where('user_id', $request->user_id);
        return $this->success(EnrolmentResource::collection($query->paginate(15)));
    }

    public function show(Enrolment $enrolment)
    {
        $this->authorizeEnrolment($enrolment, request());
        return $this->success(new EnrolmentResource($enrolment->load(['user','course','schedule'])));
    }

    public function store(StoreEnrolmentRequest $request)
    {
        $existing = Enrolment::where('user_id', $request->user()->id)
            ->where('course_id', $request->course_id)
            ->whereNotIn('status', ['cancelled'])
            ->first();
        if ($existing) return $this->error('Already enrolled in this course', 422);
        $enrolment = Enrolment::create([
            'user_id' => $request->user()->id,
            'course_id' => $request->course_id,
            'schedule_id' => $request->schedule_id,
            'status' => 'pending',
            'enrolled_at' => now(),
        ]);
        $enrolment->load(['user', 'course', 'schedule']);
        Mail::to($request->user()->email)->queue(new EnrolmentConfirmed($enrolment));
        return $this->success(new EnrolmentResource($enrolment), 'Enrolled successfully', 201);
    }

    public function update(Request $request, Enrolment $enrolment)
    {
        $data = $request->validate(['status' => 'required|in:pending,enrolled,in_progress,completed,cancelled,waitlisted', 'progress' => 'nullable|integer|min:0|max:100']);
        $enrolment->update($data);
        return $this->success(new EnrolmentResource($enrolment), 'Enrolment updated');
    }

    public function cancel(Enrolment $enrolment)
    {
        $enrolment->update(['status' => 'cancelled']);
        return $this->success(new EnrolmentResource($enrolment), 'Enrolment cancelled');
    }

    public function complete(Enrolment $enrolment)
    {
        $enrolment->update(['status' => 'completed', 'completed_at' => now(), 'progress' => 100]);
        return $this->success(new EnrolmentResource($enrolment), 'Enrolment completed');
    }

    private function authorizeEnrolment(Enrolment $enrolment, $request)
    {
        if ($request->user()->hasRole('delegate') && $enrolment->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }
    }
}
