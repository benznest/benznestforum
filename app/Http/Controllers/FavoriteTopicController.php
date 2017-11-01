<?php namespace App\Http\Controllers;
use DB;
use Input;
use Auth;

class FavoriteTopicController extends Controller {

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

	public static function arrayMap($transactions){
		return array_map(function($object){
    		return (array) $object;
		}, $transactions);
	}

	public function addFavoriteTopic($topic_id){

		$users_id = Auth::user()->id;

		// find exist?
		$favorite = \App\FavoriteTopic::where('users_id','=',$users_id)
							->where('topic_id','=',$topic_id)->first();

		if($favorite == null){
			$favorite = new \App\FavoriteTopic;
			$favorite->users_id = $users_id;
			$favorite->topic_id = $topic_id;
			$favorite->save();
		}
		return redirect('topic/'.$topic_id)->with("flag_add_favorite",true);
	}

	public function removeFavoriteTopic($favorite_id){

		$favorite = \App\FavoriteTopic::where('favorite_id','=',$favorite_id)->delete();

		return redirect('favorite');
	}

	public function getTagOnTopic($topic_id){
		$sql = "SELECT T.*
				FROM tag T,tag_topic TC
				WHERE T.tag_id = TC.tag_id and TC.topic_id = $topic_id
				";
		$data_tag = DB::select($sql);
		$data_tag = $this->arrayMap($data_tag);
		return $data_tag;
	}

	public function getAllMyFavoriteTopic(){

		$users_id = Auth::user()->id;  // get id user.

		$sql = "SELECT F.*,T.*,COUNT(C.comment_id) AS count_comment 
				FROM topic T
				LEFT JOIN comment C
				ON T.topic_id = C.topic_id ,favorite_topic F
				WHERE T.topic_id = F.topic_id
				and F.users_id = $users_id
				GROUP BY T.topic_id
				ORDER BY F.created_at DESC";

		$data_topic = DB::select($sql);
		$data_topic = $this->arrayMap($data_topic);

		// get tag.
		$i=0;
		foreach($data_topic as $row){
			$data_tag = $this->getTagOnTopic($row['topic_id']);
			$data_topic[$i]['tag'] = $data_tag;
			$i++;
		}

		return view('favorite_topic')->with("data_topic",$data_topic);
	}
}
