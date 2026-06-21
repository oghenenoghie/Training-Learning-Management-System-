<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Enrolment;
use App\Models\Payment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    use ApiResponse;

    public function enrolments(Request $request)
    {
        $stats = [
            'total' => Enrolment::count(),
            'pending' => Enrolment::where('status', 'pending')->count(),
            'enrolled' => Enrolment::where('status', 'enrolled')->count(),
            'in_progress' => Enrolment::where('status', 'in_progress')->count(),
            'completed' => Enrolment::where('status', 'completed')->count(),
            'cancelled' => Enrolment::where('status', 'cancelled')->count(),
        ];
        return $this->success($stats, 'Enrolment report');
    }

    public function revenue(Request $request)
    {
        $query = Payment::where('status', 'paid');
        $monthly = $query->select(
            DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"),
            DB::raw('SUM(amount) as total'),
            DB::raw('COUNT(*) as count')
        )->groupBy('month')->orderBy('month', 'desc')->get();
        return $this->success(['monthly' => $monthly, 'total' => Payment::where('status','paid')->sum('amount')], 'Revenue report');
    }

    public function completions(Request $request)
    {
        $data = Enrolment::with('course')
            ->where('status', 'completed')
            ->select('course_id', DB::raw('COUNT(*) as completions'))
            ->groupBy('course_id')
            ->get();
        return $this->success($data, 'Completion report');
    }

    public function delegates(Request $request)
    {
        $data = [
            'total_delegates' => \App\Models\User::where('role', 'delegate')->count(),
            'active_enrolments' => Enrolment::whereIn('status', ['enrolled','in_progress'])->distinct('user_id')->count('user_id'),
        ];
        return $this->success($data, 'Delegate report');
    }
}
