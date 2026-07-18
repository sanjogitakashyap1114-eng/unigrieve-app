<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequest; 
use App\Models\Department;

class ServiceManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['department', 'student.studentMaster']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('service_type', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%')
                  ->orWhereHas('student.studentMaster', function($studentQuery) use ($search) {
                      $studentQuery->where('name', 'like', '%' . $search . '%')
                                   ->orWhere('registration_no', 'like', '%' . $search . '%');
                  });
            });
        }
if ($request->filled('status')) {
    $query->where('status', $request->status);
}
        if ($request->filled('group')) {
            $query->where('department_id', $request->group);
        }

        $services = $query->latest()->get();
        $departments = Department::select('id', 'name')->get();
/*statistcworkload*/
$workloads=ServiceRequest::selectRaw('service_type,COUNT(*) as   total')
->groupBy('service_type')
->orderByDesc('total')
->get();
$totalRequests=$workloads->sum('total');
$workloads->transform(function ($item) use ($totalRequests) {
    $item->percentage = $totalRequests > 0
        ? round(($item->total / $totalRequests) * 100)
        : 0;

    return $item;
});
        return view('dashboard.admin.services', compact('services', 'departments','workloads'));
    }

    public function show($id)
    {
       
        $requestDetails = ServiceRequest::with(['department', 'student.studentMaster'])->findOrFail($id);
        $departments = Department::select('id', 'name')->get();

        return view('dashboard.admin.servicesdetail', compact('requestDetails', 'departments'));
    }

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'department_id' => 'required|exists:departments,id',
    ]);

    $serviceRecord = ServiceRequest::findOrFail($id);
    
    $serviceRecord->update($validated);

    return redirect()->back()->with('success', 'Department reassigned successfully.');
}
    public function reject($id)
    {
        $serviceRecord = ServiceRequest::findOrFail($id);
        $serviceRecord->update(['status' => 'Rejected']);

        return redirect()->route('services.index')->with('success', 'Request rejected.');
    }
}