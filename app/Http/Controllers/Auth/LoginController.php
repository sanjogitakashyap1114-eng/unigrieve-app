<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use Laravel\Mcp\Request;

class LoginController extends Controller
{


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
 protected function redirectTo()
{
    $role = auth()->user()->role;

    if ($role == 'admin') {
        return route('admin.dashboard');
    } 
    
    if ($role == 'department') {
        return route('department.dashboard'); 
    }
    if ($role == 'student') {
    
    return route('student.dashboard');
    }
}
    /**
     * Create a new controller instance.
     *
     * @return void
     */
 public function username()
{
    return 'loginid';
}
protected function validateLogin(Request $request)
{
    $request->validate([
        'loginid' => 'required|string',
        'password' => 'required|string',
    ]);
}
protected function credentials(Request $request)
{
    $login = $request->loginid;

    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        return [
            'email'    => $login,
            'password' => $request->password,
        ];
    }

    // registration_no se student_master ka id dhundho
    $student = DB::table('student_masters')
                  ->where('registration_no', $login)
                  ->first();

    if (!$student) {
        return [
            'student_master_id' => null, 
            'password' => $request->password,
        ];
    }

    return [
        'student_master_id' => $student->id, 
        'password' => $request->password,
    ];
}
public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
}
//  protected function loggedOut(Request $request)
// {
//     return redirect('/');
// }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}