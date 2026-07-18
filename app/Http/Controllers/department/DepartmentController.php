<?php

namespace App\Http\Controllers\department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\ServiceRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DepartmentController extends Controller
{
    /**
     * Get the authenticated department user's active department ID.
     */
    private function deptId(): int
    {
        return Auth::user()->department_id;
    }

    // ==========================================
    // 1. DASHBOARD OVERVIEW
    // ==========================================
    public function dashboard()
    {
        $deptId = $this->deptId();

        $stats = [
            'total_complaints'    => Complaint::where('department_id', $deptId)->count(),
            'pending_complaints'  => Complaint::where('department_id', $deptId)->where('status', 'Pending')->count(),
            'resolved_complaints' => Complaint::where('department_id', $deptId)->where('status', 'Resolved')->count(),
            'pending_services'    => ServiceRequest::where('department_id', $deptId)->where('status', 'Pending')->count(),
        ];

        // Fetch recent complaints alongside student master relations
        $recentComplaints = Complaint::with(['user.studentMaster'])
            ->where('department_id', $deptId)
            ->latest()
            ->take(5)
            ->get();

        // Fetch recent services requests alongside student master relations
        $recentServices = ServiceRequest::with(['user.studentMaster'])
            ->where('department_id', $deptId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.department.deptdash', compact('stats', 'recentComplaints', 'recentServices'));
    }

    // ==========================================
    // 2. COMPLAINTS CORE MANAGEMENT
    // ==========================================
    
    // MASTER LIST (ALL ASSIGNED COMPLAINTS)
    public function complaints(Request $request)
    {
        $query = Complaint::with(['user.studentMaster'])
            ->where('department_id', $this->deptId());

        // Status Filtering
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Deep Nested Relational Searching
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('complaint_id', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhereHas('user.studentMaster', function ($sm) use ($search) {
                      $sm->where('name', 'like', "%{$search}%")
                        ->orWhere('registration_no', 'like', "%{$search}%");
                  });
            });
        }

        $complaints = $query->latest()->paginate(15)->withQueryString();
        
        return view('dashboard.department.complaints', compact('complaints'));
    }

    // COMPLETE DETAIL INSPECTION PAGE
    public function showComplaint(Complaint $complaint)
    {
        // Security Gatekeeper Abort Check
        abort_unless($complaint->department_id === $this->deptId(), 403, 'Unauthorized Access to Department File Asset.');
        
        $complaint->load(['user.studentMaster']);
        
        return view('dashboard.department.complaint_detail', compact('complaint'));
    }

    // COMMIT MANUAL REMARK STATUS UPDATE 
    public function updateComplaintStatus(Request $request, Complaint $complaint)
    {
        abort_unless($complaint->department_id === $this->deptId(), 403);
        
        $validated = $request->validate([
            'status'  => 'required|in:Pending,In Progress,Resolved,Rejected',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $complaint->update($validated);
        
        return back()->with('success', 'Complaint workflow state and historical logs updated.');
    }

    // DIRECT QUICK REJECT SHUTDOWN ACTION
    public function quickRejectComplaint(Complaint $complaint)
    {
        abort_unless($complaint->department_id === $this->deptId(), 403);
        
        $complaint->update([
            'status'  => 'Rejected',
            'remarks' => 'Your application was rejected.'
        ]);
        
        return back()->with('success', 'Complaint file terminated with automatic standard remark applied.');
    }

    // ==========================================
    // 3. SERVICES CORE MANAGEMENT
    // ==========================================

    // MASTER LIST (ALL ASSIGNED SERVICE REQUESTS)
    public function services(Request $request)
    {
        $query = ServiceRequest::with(['user.studentMaster'])
            ->where('department_id', $this->deptId());

        // Status Filtering
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Deep Nested Relational Searching 
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('service_id', 'like', "%{$search}%")
                  ->orWhere('service_type', 'like', "%{$search}%")
                  ->orWhereHas('user.studentMaster', function ($sm) use ($search) {
                      $sm->where('name', 'like', "%{$search}%")
                        ->orWhere('registration_no', 'like', "%{$search}%");
                  });
            });
        }

        $services = $query->latest()->paginate(15)->withQueryString();
        
        return view('dashboard.department.services', compact('services'));
    }

    // COMPLETE DETAIL INSPECTION PAGE
    public function showService(ServiceRequest $serviceRequest)
    {
        // Security Gatekeeper Abort Check
        abort_unless($serviceRequest->department_id === $this->deptId(), 403, 'Unauthorized Access to Department File Asset.');
        
        $serviceRequest->load(['user.studentMaster']);
        
        return view('dashboard.department.service_detail', compact('serviceRequest'));
    }

    // COMMIT MANUAL REMARK STATUS UPDATE
    public function updateServiceStatus(Request $request, ServiceRequest $serviceRequest)
    {
        abort_unless($serviceRequest->department_id === $this->deptId(), 403);
        
        $validated = $request->validate([
            'status'  => 'required|in:Pending,In Progress,Resolved,Rejected',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $serviceRequest->update($validated);
        
        return back()->with('success', 'Service request workflow state and logs committed.');
    }

    // DIRECT QUICK REJECT SHUTDOWN ACTION
    public function quickRejectService(ServiceRequest $serviceRequest)
    {
        abort_unless($serviceRequest->department_id === $this->deptId(), 403);
        
        $serviceRequest->update([
            'status'  => 'Rejected',
            'remarks' => 'Your application was rejected.'
        ]);
        
        return back()->with('success', 'Service asset terminated with automatic standard remark applied.');
    }

    // ==========================================
    // 4. UTILITIES, NOTIFICATIONS & PROFILE
    // ==========================================
    public function notifications()
    {
        $deptId = $this->deptId();

        $recentComplaints = Complaint::where('department_id', $deptId)
            ->latest()->take(10)->get()
            ->map(fn($c) => [
                'title'   => 'Complaint Update: ' . $c->category,
                'message' => 'Record #' . $c->complaint_id . ' changed context state status to: ' . $c->status,
                'time'    => $c->updated_at->diffForHumans(),
            ]);

        $recentServices = ServiceRequest::where('department_id', $deptId)
            ->latest()->take(10)->get()
            ->map(fn($s) => [
                'title'   => 'Service Asset Update: ' . $s->service_type,
                'message' => 'Record #' . $s->service_id . ' changed context state status to: ' . $s->status,
                'time'    => $s->updated_at->diffForHumans(),
            ]);

        $notifications = $recentComplaints->concat($recentServices)->sortByDesc('time')->values();

        return view('dashboard.department.notifications', compact('notifications'));
    }

    public function profile()
    {
        $user = Auth::user();
        $department = Department::find($this->deptId());
        return view('dashboard.department.profile', compact('user', 'department'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);
        
        $user->update($validated);
        return redirect()->route('department.profile')->with('success', 'Profile metadata updated successfully.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current logged password context string is incorrect.'])->withInput();
        }

        $user->update(['password' => Hash::make($request->new_password)]);
        return redirect()->route('department.profile')->with('success', 'Security authentication credentials mutated successfully.');
    }
}