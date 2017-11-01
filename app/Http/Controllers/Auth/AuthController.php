<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Input;
use Hash;
use Auth;
use Session;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}


	public function authenticate()
    {
    	$email = Input::get('email');
    	$password = Input::get('password');
    	$errors = array("Email or password incorrect.");
    	//$password = Hash::make($password);

    	// check status user.
    	$user = \App\User::where('email',$email)->first();
    	if($user != null){
	        if($user->status == "banned"){
	        	return redirect('/sorry')->with("email",$email);
	        }
    	}

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            return redirect('/');
        }

        return redirect('auth/login')->with("errors",$errors);
    }

    public function showViewBanned(){
    		$email = Session::get('email');
			return view('banned')->with("email",$email);
    }
}
