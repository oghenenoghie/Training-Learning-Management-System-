<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $enrolments = $user->enrolments()->with('course', 'certificate')->get();

        $stats = [
            'enrolled'     => $enrolments->count(),
            'completed'    => $enrolments->where('status', 'completed')->count(),
            'certificates' => $user->certificates()->count(),
            'upcoming'     => $enrolments->whereIn('status', ['enrolled', 'active'])->count(),
        ];

        $activeEnrolments = $enrolments->whereIn('status', ['enrolled', 'active'])->take(5);

        $upcomingSchedules = $user->enrolments()
            ->with(['course', 'schedule'])
            ->whereHas('schedule', fn($q) => $q->where('start_date', '>=', now()))
            ->limit(5)
            ->get()
            ->map(fn($e) => (object)[
                'course' => $e->course,
                'start_date' => $e->schedule?->start_date,
            ]);

        $recentCertificates = $user->certificates()->with('course')->latest()->take(3)->get();

        return view('dashboard.index', compact('stats', 'activeEnrolments', 'upcomingSchedules', 'recentCertificates'));
    }

    public function courses()
    {
        $user = Auth::user();
        $all = $user->enrolments()->with('course.category', 'certificate')->get();

        $active    = $all->whereIn('status', ['enrolled', 'active']);
        $completed = $all->where('status', 'completed');
        $upcoming  = $all->where('status', 'pending');

        return view('dashboard.courses', compact('active', 'completed', 'upcoming'));
    }

    public function certificates()
    {
        $certificates = Auth::user()->certificates()->with('course')->latest()->get();
        return view('dashboard.certificates', compact('certificates'));
    }

    public function payments()
    {
        $payments = Auth::user()->payments()->with('enrolment.course')->latest()->get();
        return view('dashboard.payments', compact('payments'));
    }

    public function profile()
    {
        return view('dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,'.$user->id,
            'phone'        => 'nullable|string|max:20',
            'organisation' => 'nullable|string|max:255',
            'job_title'    => 'nullable|string|max:255',
            'password'     => 'nullable|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'phone', 'organisation', 'job_title');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }
}
