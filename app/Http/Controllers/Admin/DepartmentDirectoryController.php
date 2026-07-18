<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DepartmentDirectoryController extends Controller
{
    
    public function index()
    {
        $departments = Department::withCount([
            'staff',
            'complaints as pending_count' => function ($query) {
                $query->where('status', 'Pending');
            },
            'complaints as progress_count' => function ($query) {
                $query->where('status', 'In Progress');
            },
            'complaints as resolved_count' => function ($query) {
                $query->where('status', 'Resolved');
            }
        ])->get();

        return view('dashboard.admin.departmentsdetail', compact('departments'));
    }

   
    public function show($id)
    {
        $department = Department::with(['staff'])->withCount([
            'complaints as pending_count' => function ($query) {
                $query->where('status', 'Pending');
            },
            'complaints as progress_count' => function ($query) {
                $query->where('status', 'In Progress');
            },
            'complaints as resolved_count' => function ($query) {
                $query->where('status', 'Resolved');
            }
        ])->findOrFail($id);

        return view('dashboard.admin.manageDepartment', compact('department'));
    }


    public function addStaff(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'staff_name'  => 'required|string|max:255',
            'staff_email' => 'required|email|unique:users,email',
            'staff_phone' => 'nullable|string|max:20',
            'password'    => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'          => $request->staff_name,
            'email'         => $request->staff_email,
            'phone'         => $request->staff_phone,
            'password'      => Hash::make($request->password),
            'role'          => 'department', 
            'department_id' => $department->id,
        ]);

        return redirect()->back()->with('success', 'New staff member successfully enrolled in this department!');
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:255|unique:departments,name,' . $id,
            'head_name'  => 'required|string|max:255',
            'dept_email' => 'required|email|unique:departments,email,' . $id,
            'phone'      => 'nullable|string|max:20',
            'description'=> 'nullable|string',
        ]);

        $department->update([
            'name'        => $validated['name'],
            'head_name'   => $validated['head_name'], // अपने DB कॉलम के नाम के अनुसार मैच करें (head या head_name)
            'email'       => $validated['dept_email'],
            'phone'       => $validated['phone'],
            'description' => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'Department configuration updated successfully.');
    }


    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        
        User::where('department_id', $id)->update(['department_id' => null]);
        
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department structure removed from system memory.');
    }
}