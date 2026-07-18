<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentMaster;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
   

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered(
            $user = $this->create($request->all())
        ));

        return redirect()
            ->route('register')
            ->with('success', 'Registration successful. Please login.');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['string'],

            'regId' => [
                'required',
                'string',
                'exists:student_masters,registration_no',
                function ($attribute, $value, $fail) {

                    $studentId = StudentMaster::where(
                        'registration_no',
                        $value
                    )->value('id');

                    if (
                        $studentId &&
                        User::where('student_master_id', $studentId)->exists()
                    ) {
                        $fail('This registration number is already registered.');
                    }
                },
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        $student = StudentMaster::where('registration_no', $data['regId'])->first();
        return User::create([
            'name' => $student->name,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'student_master_id' => $student->id,
            'role' => 'student',

        ]);
    }
}
