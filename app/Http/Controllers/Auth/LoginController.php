<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/customers';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function authenticated(Request $request, $user)
    {
        // $user = Auth::user();
        $branches = \App\Branch::all();
        $antrian = \App\Antrian::where('branch_id', $user['branch_id'])->get();
        $antrian_mobil = \App\Antrian::where('branch_id',session('branch_id'))->where('type', 'mobil')->count();
        $antrian_motor = \App\Antrian::where('branch_id',session('branch_id'))->where('type', 'motor')->count();
        session(['user' => $user, 
                'branch_name' => $user->branch->branch_name,
                'branch' => $user->branch,
                'branch_id' => $user['branch_id'],
                'branches' => $branches,
                'antrian' => $antrian,
                'antrian_mobil' => $antrian_mobil,
                'antrian_motor' => $antrian_motor
                ]);
        if($user['role_id'] == 2){

            return redirect('/incomes/create');    
        }

        return redirect('/home');        
        
    }
}
