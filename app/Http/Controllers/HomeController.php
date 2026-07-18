<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('student.dashboard');
        //    return redirect()->route('login');
    }
//     public function index()
// {
//     $user = auth()->user();

//     if ($user->role == 'student') {
//         return redirect()->route('student.dashboard');
//     }

//     if ($user->role == 'staff') {
//         return redirect()->route('staff.dashboard');
//     }

//     if ($user->role == 'admin') {
//         return redirect()->route('admin.dashboard');
//     }

//     abort(403);
// }
}
