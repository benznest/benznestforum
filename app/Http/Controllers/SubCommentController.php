<?php namespace App\Http\Controllers;
use DB;
use Input;
use Auth;
use Redirect;
class SubCommentController extends Controller {

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

	public function getAllSubCommentInComment($comment_id){
		//$sub_comment = \App\SubComment::where('comment_id','=',$comment_id)->get();

		$sql = "SELECT S.*,U.name 
				FROM sub_comment S,users U
				WHERE S.users_id = U.id and S.comment_id = $comment_id
				ORDER BY S.created_at ASC";

		$data_sub_comment = DB::select($sql);
		$this->closeConnectionDB();
		
		$data_sub_comment  = $this->arrayMap($data_sub_comment);

		//$sub_comment = (array)$sub_comment;
		//$sub_comment = $this->arrayMap($sub_comment);
		return $data_sub_comment;
	}


	public function newSubComment(){
		$this->auth();
		$topic_id 	= Input::get('topic_id');
		$comment_id = Input::get('comment_id');
		$users_id   = Auth::user()->id;
		$sub_comment_body  = Input::get('sub_comment_body');

		$sub_comment = new \App\SubComment;
		$sub_comment ->users_id = $users_id;
		$sub_comment ->comment_id = $comment_id;
		$sub_comment ->sub_comment_body = nl2br(trim($sub_comment_body));
		$sub_comment ->save();

		Redirect::to('/topic/'.$topic_id.'')->send();
		//return $this->showViewTopicInCategory($category_id);
	}

}
