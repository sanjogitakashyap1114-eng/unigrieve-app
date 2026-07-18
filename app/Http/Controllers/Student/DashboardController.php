<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Notice;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Logged-in Student/User ID

        // 1. Fetch Stats Counts for this specific student
        $totalComplaints = Complaint::where('student_id', $userId)->count();

        $pendingComplaints = Complaint::where('student_id', $userId)
            ->where('status', 'pending')
            ->count();

        $resolvedComplaints = Complaint::where('student_id', $userId)
            ->where('status', 'resolved')
            ->count();

        $totalServices = ServiceRequest::where('student_id', $userId)->count();

        // 2. Fetch Recent Submissions (Combine Complaints & Service Requests)
        // We fetch them separately, format them cleanly, and merge them sorted by date.

        $recentComplaints = Complaint::where('student_id', $userId)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'display_id' => $item->complaint_id,
                    'category' => $item->category,
                    'status' => $item->status,
                    'date' => $item->created_at,
                    'type' => 'complaint'
                ];
            });

        $recentServices = ServiceRequest::where('student_id', $userId)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'display_id' => $item->service_id,
                    'category' => $item->service_type,
                    'status' => $item->status,
                    'date' => $item->created_at,
                    'type' => 'service'
                ];
            });
        $notices = Notice::where('is_active', 1)
            ->where(function ($query) {
                $query->whereNull('last_date')
                    ->orWhereDate('last_date', '>=', now());
            })
            ->with('department')   // Optional, if you want to show who published it
            ->latest()
            ->take(5)
            ->get();
        // Merge both collections and sort them by the latest date, then take the top 5 overall
        $recentSubmissions = $recentComplaints->concat($recentServices)
            ->sortByDesc('date')
            ->take(5);
        return view('dashboard.student.studentdash', compact(
            'totalComplaints',
            'pendingComplaints',
            'resolvedComplaints',
            'totalServices',
            'recentSubmissions',
            'notices'
        ));
    }
    public function allNotices()
{
    $notices = Notice::where('is_active', 1)
        ->where(function ($query) {
            $query->whereNull('last_date')
                  ->orWhereDate('last_date', '>=', now());
        })
        ->latest()
        ->paginate(10);

    return view('dashboard.student.notices', compact('notices'));
}

}
