<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class StudentManagementController extends Controller
{
    public function index(Request $request)
    {
        // 1. Only fetch users where role is student, with their master profiles
        $query = User::where('role', 'student')
            ->with(['studentMaster'])
            ->withCount('serviceRequests');

        // 2. Apply Top Search Filter (searches name, email, or registration number)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('studentMaster', function($m) use ($search) {
                      $m->where('registration_no', 'like', "%{$search}%");
                  });
            });
        }

        // 3. Get distinct records sorted by latest registration to avoid duplicates
        $students = $query->latest()->get()->unique('id');

        return view('dashboard.admin.students', compact('students'));
    }

    public function edit($id)
    {
        $student = User::where('role', 'student')->with('studentMaster')->findOrFail($id);
        return view('dashboard.admin.studentsdetail', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        
        // Update User account data
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update Student Profile Master table fields safely
        if ($student->studentMaster) {
            $student->studentMaster->update([
                'registration_no' => $request->registration_no,
                'phone'           => $request->phone,
                'batch'           => $request->batch,
                'course'          => $request->course,
            ]);
        }

        return redirect()->route('admin.students.index')->with('success', 'Student system profile updated successfully.');
    }
}