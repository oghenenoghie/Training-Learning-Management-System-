<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrolment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrolmentWebController extends Controller
{
    public function checkout(Request $request)
    {
        $course = Course::with('schedules')->where('id', $request->course)
            ->where('is_published', true)->firstOrFail();
        $schedules = $course->schedules()->where('status', 'open')
            ->where('start_date', '>=', now())->get();
        return view('enrolment.checkout', compact('course', 'schedules'));
    }

    public function initiate(Request $request)
    {
        $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'schedule_id' => 'nullable|exists:course_schedules,id',
            'gateway'     => 'required|in:paystack,flutterwave',
        ]);

        // Delegate to API PaymentController via internal call or redirect
        return redirect('/api/v1/payments/initiate-redirect?' . http_build_query($request->all()));
    }

    public function success(Request $request)
    {
        $enrolment = null;
        if ($request->has('enrolment_id')) {
            $enrolment = Enrolment::with('course', 'payment')
                ->where('user_id', Auth::id())
                ->find($request->enrolment_id);
        }
        return view('enrolment.success', compact('enrolment'));
    }
}
