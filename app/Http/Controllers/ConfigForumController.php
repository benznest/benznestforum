<?php namespace App\Http\Controllers;
use DB;

class ConfigForumController extends Controller {

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
	public function index()
	{
		return view('welcome');
	}

	public static function arrayMap($transactions){
		return array_map(function($object){
    		return (array) $object;
		}, $transactions);
	}

	public static function getForumName(){
		$sql = "SELECT *
				FROM config_forum
				";
		$data_forum = DB::select($sql);
		$data_forum = ConfigForumController::arrayMap($data_forum);
		$data_forum = $data_forum[0];
		return $data_forum['forum_name'];
	}

	public static function getAllCategory(){
		$sql = "SELECT *
				FROM category
				";
		$data_category = DB::select($sql);
		$data_category= ConfigForumController::arrayMap($data_category);
		 //dd($category[0]->category_name);
		return $data_category;
	}

}
