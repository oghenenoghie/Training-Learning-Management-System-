<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrolment;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'revenue'    => Payment::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->sum('amount'),
            'enrolments' => Enrolment::whereMonth('created_at', now()->month)->count(),
            'delegates'  => User::where('role', 'delegate')->count(),
            'courses'    => Course::where('is_published', true)->count(),
        ];

        $recentEnrolments = Enrolment::with('user', 'course')->latest()->take(8)->get();

        $revenueChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenueChart[$date->format('M')] = Payment::where('status', 'paid')
                ->whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month)
                ->sum('amount');
        }

        return view('admin.dashboard', compact('stats', 'recentEnrolments', 'revenueChart'));
    }

    public function enrolments()
    {
        $enrolments = Enrolment::with('user', 'course', 'schedule', 'payment')
            ->latest()->paginate(20);
        return view('admin.enrolments.index', compact('enrolments'));
    }

    public function approveEnrolment(Enrolment $enrolment)
    {
        $enrolment->update(['status' => 'enrolled']);
        return back()->with('success', 'Enrolment approved.');
    }

    public function cancelEnrolment(Enrolment $enrolment)
    {
        $enrolment->update(['status' => 'cancelled']);
        return back()->with('success', 'Enrolment cancelled.');
    }

    public function payments()
    {
        $payments = Payment::with('user', 'enrolment.course')->latest()->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function reports()
    {
        $stats = [
            'total_enrolments' => Enrolment::count(),
            'completed'        => Enrolment::where('status', 'completed')->count(),
            'total_revenue'    => Payment::where('status', 'paid')->sum('amount'),
            'completion_rate'  => Enrolment::count() > 0
                ? round(Enrolment::where('status', 'completed')->count() / Enrolment::count() * 100)
                : 0,
        ];

        $revenueByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenueByMonth[$date->format('M')] = Payment::where('status', 'paid')
                ->whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month)
                ->sum('amount');
        }

        $completionRates = Course::withCount([
            'enrolments',
            'enrolments as completed_count' => fn($q) => $q->where('status', 'completed'),
        ])->having('enrolments_count', '>', 0)->get()->map(fn($c) => [
            'title'     => $c->title,
            'enrolled'  => $c->enrolments_count,
            'completed' => $c->completed_count,
            'rate'      => $c->enrolments_count > 0 ? round($c->completed_count / $c->enrolments_count * 100) : 0,
        ]);

        return view('admin.reports.index', compact('stats', 'revenueByMonth', 'completionRates'));
    }
}
