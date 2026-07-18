<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class MyComplaintsController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Complaint::where('student_id', $userId);

       
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('id', 'like', '%' . str_replace('#CMP', '', $searchTerm) . '%');
            });
        }

        if ($request->filled('status') && $request->status != 'All Status') {
            $query->where('status', $request->status);
        }

        if ($request->filled('category') && $request->category != 'All Categories') {
            $query->where('category', $request->category);
        }

        $complaints = $query->latest()->get();

        return view('dashboard.student.mycomplaint', compact('complaints'));
    }
   
public function show($id)
{
    $complaint = Complaint::where('student_id', auth()->id())->findOrFail($id);

    return view('dashboard.student.viewcomplaint', compact('complaint'));
}
}