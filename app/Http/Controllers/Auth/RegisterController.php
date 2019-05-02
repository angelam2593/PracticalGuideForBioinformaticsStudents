<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Smer;
use App\Year;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surename' => ['required', 'string', 'max:255'],
            'indeks' => ['required', 'string', 'max:255'],
            'smer' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
            'surename' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $smer = $data['smer'];
        $godina = $data['year'];
        $smer_id = Smer::where('ime', $smer)->first()->id;
        $godina_id = Year::where('name', $godina)->first()->id;
        return User::create([
            'name' => $data['name'],
            'surename' => $data['surename'],
            'studentid' => $data['indeks'],
            'smer_id' => $smer_id,
            'godina_id' => $godina_id,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
