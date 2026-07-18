<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfile()
    {
        return view('dashboard.student.profile'); 
    }

   public function updateProfile(\Illuminate\Http\Request $request)
{
    $request->validate([
        'phone'    => 'required|string|max:15',
        'semester' => 'required|integer|between:1,8',
    ]);

    $user = auth()->user();
    if ($user && $user->studentMaster) {
        
       $user->studentMaster->update([
            'phone'    => $request->phone,
            'semester' => $request->semester,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    return redirect()->back()->with('error', 'Linked student master record not found.');
}
}