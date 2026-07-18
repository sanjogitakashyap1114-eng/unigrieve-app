<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class AddDepartmentController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
        'name'       => 'required|string|max:255',
        'staff_name'  => 'required|string|max:255',
        'staff_email' => 'required|email|unique:users,email',
        'password'    => 'required|min:8|confirmed',
    ]);

    // Step 1: departments table
    $department = Department::create([
        'name'        => $request->name,
        'description' => $request->description,
        'head_name'   => $request->head_name,
        'email'       => $request->dept_email,
        'phone'       => $request->phone,
    ]);

    // Step 2: users table — staff account
    User::create([
        'name'          => $request->staff_name,
        'email'         => $request->staff_email,
        'phone'         =>$request->staff_phone,
        'password'      => Hash::make($request->password),
        'role'          => 'department',
        'department_id' => $department->id,
    ]);
return response()->json([
    'message' => 'Department and staff account created successfully!'
], 200);
 // return redirect()->back()->with('success', 'Department and staff account created successfully!');
   
}
}
