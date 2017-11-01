<?php namespace App\Http\Controllers;
use DB;
use Input;
use Auth;
use Redirect;
class CommentController extends SubCommentController {

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
	
	public function __construct()
	{
		//$this->middleware('auth');
	}

	public function auth(){
		//DB::disconnect('benznestforum');
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

	public function getAllCommentInTopic($topic_id){
		$sql = "SELECT C.*,U.name,
					(
						SELECT IFNULL(SUM(V.vote_value),0)
				     	FROM vote_useful_comment V
				     	WHERE  V.comment_id = C.comment_id 
				    ) AS vote_comment_sum
				FROM comment C,users U
				WHERE C.users_id = U.id and C.topic_id = $topic_id
				ORDER BY C.created_at ASC";
		$data_comment = DB::select($sql);
		$this->closeConnectionDB();
		$data_comment  = $this->arrayMap($data_comment);
		return $data_comment;
	}

	public function newComment(){
		$this->auth();
		$topic_id = Input::get('topic_id');
		$comment_body  = Input::get('comment_body');
		$users_id  = Auth::user()->id;

		$comment = new \App\Comment;
		$comment ->users_id = $users_id;
		$comment ->topic_id = $topic_id;
		$comment ->comment_body = nl2br(trim($comment_body));
		$comment ->save();

		Redirect::to('/topic/'.$topic_id.'')->send();
		//return $this->showViewTopicInCategory($category_id);
	}

	public function voteRatingComment($topic_id,$comment_id,$rating_value){
		$users_id = Auth::user()->id; // get id user.

		//user was voted before. delete it.
		\App\Vote_useful_comment::where('users_id','=',$users_id)
								->where('comment_id','=',$comment_id)->delete();

		if($rating_value == "useful"){
			$this->addVoteRatingComment($comment_id,1);
		}else{
			$this->addVoteRatingComment($comment_id,-1);
		}
		
		Redirect::to('topic/'.$topic_id.'')->send();
	}

	public function addVoteRatingComment($comment_id,$vote_value){
		$users_id = Auth::user()->id; // get id user.
		$vote = new \App\Vote_useful_comment;
		$vote->comment_id = $comment_id;
		$vote->users_id   = $users_id;
		$vote->vote_value = $vote_value;
		$vote->save();
	}

}
