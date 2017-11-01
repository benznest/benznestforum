<?php namespace App\Http\Controllers;
use DB;
use Input;
use Auth;

class RequestController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */


	public static function arrayMap($transactions){
		return array_map(function($object){
    		return (array) $object;
		}, $transactions);
	}

	public function addRequest(){
		$users_id = Auth::user()->id;
		$topic_id 		 = Input::get('request_topic_id');
     	$comment_id  	 = Input::get('request_comment_id');
      	$sub_comment_id  = Input::get('request_sub_comment_id');
      	$reason_main 	 = Input::get('reason_main');
      	$reason_detail   = Input::get('reason_detail');
      	$contact_detail  = Input::get('contact_detail');


      	$request = new \App\Request;
		$request->users_id = $users_id;
		$request->topic_id = $topic_id;
		$request->request_name  = "remove";
		$target = "topic";

		if($comment_id != "none" || $comment_id !=""){
			$request->comment_id     = $comment_id;
			$target = "comment";
		}

		if($sub_comment_id != "none" || $sub_comment_id !=""){
			$request->sub_comment_id = $sub_comment_id;
			$target = "sub_comment";
		}

		$request->request_target    = $target;
		$request->reason_main       = $reason_main;
		$request->reason_detail     = $reason_detail;
		$request->contact_detail    = $contact_detail;
		$request->request_status   = "waiting check";
		$request->save();
		return redirect('topic/'.$topic_id)->with("flag_request",true);

	}

}
