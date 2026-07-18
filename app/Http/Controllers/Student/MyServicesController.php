<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
class MyServicesController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = ServiceRequest::where('student_id', $userId);

        // Filter: Search Input (ID or Service Type)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('service_type', 'like', '%' . $searchTerm . '%')
                  ->orWhere('service_id', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter: Status
        if ($request->filled('status') && $request->status != 'All Status') {
            $query->where('status', $request->status);
        }

        $services = $query->latest()->get();
        return view('dashboard.student.myservices', compact('services'));
    }

    public function show($id)
    {
        $service = ServiceRequest::where('student_id', Auth::id())->findOrFail($id);
        return view('dashboard.student.viewservices', compact('service'));
    }
}

