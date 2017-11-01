<?php namespace App\Http\Controllers;
use DB;
use Input;
use Auth;
use Redirect;
use Hash;
use Image;
use Session;

class UserController extends TopicController {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	
	public function closeConnectionDB(){
		$db_name = DB::connection()->getDatabaseName();
		if($db_name){
			DB::disconnect($db_name);
		}
	}

	public function __construct()
	{
		//$this->middleware('auth');
	}

	public function auth(){
		if(Auth::guest()){
			Redirect::to('auth\login')->send();
		}
	}

	public function arrayMap($transactions){
		return array_map(function($object){
    		return (array) $object;
		}, $transactions);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */

	public function index()
	{
		return view('home');
	}

	public function profile(){
		$this->auth();
		$users_id = Auth::user()->id;

		$msg         = Session::get('msg');
		$status      = Session::get('status');
		//dd($msg);
		
		$sql = "SELECT *
				FROM users U
				WHERE U.id = $users_id";

		$data_profile = DB::select($sql);
		$this->closeConnectionDB();
		
		$data_profile = $this->arrayMap($data_profile);
		$data_profile = $data_profile[0];

		if($data_profile['photo']==null || $data_profile['photo']==""){
			$data_profile['photo'] = "default.png";
		}

		return view('auth/profile_edit')->with('data_profile',$data_profile)
										->with("msg",$msg)
							            ->with("status",$status);
	}

	public function saveChangeProfile(){
		$user_id   = Auth::user()->id;
		$name      = Input::get('name');
		$email     = Input::get('email');
		$birthday  = Input::get('birthday');
		$gender    = Input::get('gender');

		$msg = "change profile successful.";
		$status = "success";

		// save photo
		if( Input::file('photo')){
			$extension = Input::file('photo')->getClientOriginalExtension();
			$whitelist = array('png','jpg','jpeg');

			if(in_array($extension, $whitelist)){
		        $image     = Image::make(Input::file('photo'));
		        $filename  = $user_id  . '.' . $extension;
		        $path = 'resources/assets/img/profile/' . $filename;
		        $image = $this->resizePhoto($image);
		        $image->save($path);

		        $sql = "UPDATE users SET name = '$name', email = '$email' , gender = '$gender' , 
										birthday='$birthday' , photo = '$filename'
					WHERE id = $user_id";
				DB::select($sql);
				$this->closeConnectionDB();


			}else{
				$msg = "Please check extension your photo should be .png .jpg or .jpeg";
				$status = "fail";
			}
    	}
    	else{
    		$sql = "UPDATE users SET name = '$name', email = '$email' , gender = '$gender' , 
									birthday='$birthday'
				WHERE id = $user_id";
			DB::select($sql);
			$this->closeConnectionDB();
    	}

		return redirect('/profile')->with("msg",$msg)
 							       ->with("status",$status);
	}

	public function changePassword(){

		$old_password  = Input::get('old_password');
		$current_password_hashed = Auth::user()->password;

	    if (Hash::check($old_password, $current_password_hashed)) // check old password.
		{
			$new_password  		   = Input::get('new_password');
			$new_password_confirm  = Input::get('new_password_confirm');

			if($new_password = $new_password_confirm){
				$user = \App\User::findOrFail(Auth::user()->id);
		        $user->password = Hash::make(Input::get('new_password'));
		        $user->save();
		        return $this->profile() ->with("status","success")
		        						->with("msg","your password changed successfully.");
			}
		}
		return $this->profile() ->with("status","fail")
		        				->with("msg","Your old password or new password Invalid , please try again and check it.");

	}

	public function showViewUserProfile($users_id){  // display profile in public.
		//$users_id = Auth::user()->id;
		
		$sql = "SELECT * 
				FROM users U
				WHERE U.id = $users_id";

		$data_profile = DB::select($sql);
		$this->closeConnectionDB();

		$data_profile = $this->arrayMap($data_profile);
		$data_profile = $data_profile[0];

		if($data_profile['photo']==null || $data_profile['photo']==""){
			$data_profile['photo'] = "default.png";
		}

		// get Topic created by this user.
		$data_topic = $this->getAllTopicCreatedByUser($users_id); // extend by TopicController.
		$count_topic = count($data_topic);
		$data_topic_comment = $this->getAllTopicHaveCommentByUser($users_id); // extend by TopicController.
		$count_topic_comment = count($data_topic_comment);

		return view('auth/profile_user')->with("data_profile",$data_profile)
										->with("data_topic",$data_topic)
										->with("data_topic_comment",$data_topic_comment)
										->with("count_topic",$count_topic)
										->with("count_topic_comment",$count_topic_comment);
	}

	public function resizePhoto($image){
            if($image->width() > 500){

                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $image->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            if($image->height() > 500){

                // resize the image to a height of 200 and constrain aspect ratio (auto width)
                $image->resize(null, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });

            }
            return  $image;
    }
}
