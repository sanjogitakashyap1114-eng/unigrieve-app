<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\StudentMaster;
use App\Models\Complaint;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class   AdminController extends Controller
{
    public function index()
    {
        // 1. Fetch live summary counts for your top stat cards
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'Pending')->count();
        $resolvedComplaints = Complaint::where('status', 'Resolved')->count();
        $totalServices = ServiceRequest::count();

        // 2. Fetch the 5 most recent complaints (with their linked master student record)
        $recentComplaints = Complaint::with('user.studentMaster', 'department')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 3. Fetch the 5 most recent service requests
        $recentServices = ServiceRequest::with('student.studentMaster', 'department')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            $departmentData = Complaint::select('department_id', \DB::raw('count(*) as total'))
    ->groupBy('department_id')
    ->get();
        $maxComplaints = $departmentData->max('total') ?: 1; // Prevent division by zero
        $maxBarHeight = 160;

        $analyticsCharts = $departmentData->map(function ($item) use ($maxComplaints, $maxBarHeight) {
            return [
                'name' => $item->department ?? 'Other',
                'count' => $item->total,
                // Proportional height mapping to pixel configurations smoothly
                'height' => round(($item->total / $maxComplaints) * $maxBarHeight)
            ];
        });
        // 4. Return the dashboard view and inject all our database data into it
        return view('dashboard.admin.admindash', compact(
            'totalComplaints',
            'pendingComplaints',
            'resolvedComplaints',
            'totalServices',
            'recentComplaints',
            'recentServices',
            'analyticsCharts'
        ));
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');

        // Skip heading row
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {

            StudentMaster::create([
                'registration_no' => $row[0],
                'name' => $row[1],
                'father_name' => $row[2],
                'gender' => $row[3],
                // 'date_of_birth' => $row[4],
                'date_of_birth' => date('Y-m-d', strtotime($row[4])),
                'email' => $row[5],
                'phone' => $row[6],
                'address' => $row[7],
                'department' => $row[8],
                'course' => $row[9],
                'batch' => $row[10],
                'semester' => $row[11],
            ]);
        }

        fclose($file);

        return back()->with('Success');
    }
}
