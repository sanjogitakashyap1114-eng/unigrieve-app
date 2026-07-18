<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Department;

class AdminComplaintController extends Controller
{
    public function index(Request $request)
    {
        // student info load karne ke liye 'user.studentMaster' relation add kiya
        $query = Complaint::with(['user.studentMaster', 'department']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('complaint_id', 'LIKE', "%{$search}%")
                    ->orWhere('category', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest()->paginate(15);
        $departments = Department::orderBy('name', 'asc')->get();

        /* Complaint Analytics */
        $complaintWorkload = Complaint::selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $totalComplaints = $complaintWorkload->sum('total');

        $complaintWorkload->transform(function ($item) use ($totalComplaints) {
            $item->percentage = $totalComplaints > 0
                ? round(($item->total / $totalComplaints) * 100)
                : 0;

            return $item;
        });
        return view('dashboard.admin.complaints', compact('complaints', 'departments','complaintWorkload'));
    }

    public function show($id)
    {
        // Individual Complaint Detail Engine
        $complaintDetails = Complaint::with(['user.studentMaster', 'department'])->findOrFail($id);
        $departments = Department::select('id', 'name')->get();

        return view('dashboard.admin.complaintdetail', compact('complaintDetails', 'departments'));
    }

    public function handleAction(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        // Single unified operational form switch handler
        switch ($request->input('action_type')) {
            case 'reassign':
                $request->validate(['department_id' => 'required|exists:departments,id']);
                $complaint->update([
                    'department_id' => $request->department_id,
                    'status' => 'In Progress'
                ]);
                $msg = 'Complaint successfully rerouted to new department.';
                break;

            case 'reject':
                $complaint->update(['status' => 'Rejected',
                'remark'=>'Your application is  rejected']);
                $msg = 'Complaint verification signature updated to Rejected.';
                break;

            case 'resolve':
                $complaint->update(['status' => 'Resolved']);
                $msg = 'Complaint case marked as Resolved.';
                break;

            default:
                return redirect()->back()->with('error', 'Invalid tracking command requested.');
        }

        return redirect()->route('complaints.index')->with('success', $msg);
    }
}                                                              

