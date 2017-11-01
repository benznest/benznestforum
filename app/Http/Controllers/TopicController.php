<?php namespace App\Http\Controllers;
use DB;
use Input;
use Auth;
use Redirect;
use Session;


class TopicController extends CommentController {

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

	public function getTopicAll()
	{
		// $sql = "SELECT C.*,COUNT(T.topic_id) AS count_topic,COUNT(Co.comment_id) AS count_comment
		// 		FROM category C
		// 		LEFT JOIN topic T
		// 		ON T.category_id = C.category_id
		// 		LEFT JOIN comment Co
		// 		ON T.topic_id = Co.topic_id
		// 		GROUP BY category_id";

		$sql = "SELECT C.*
				FROM category C";
				
		$data_category = DB::select($sql);
		$this->closeConnectionDB();

		$data_category = $this->arrayMap($data_category);

		return view('home') ->with("data_category",$data_category);
						 	
	}

	public function getCategoryName($category_id){
		 $category = \App\Category::where('category_id','=',$category_id)->get();
		 $category = $category[0];
		 //dd($category[0]->category_name);
		 return $category->category_name;
	}

	public function showViewNewTopic(){
		$this->auth();
		//$category_name = $this->getCategoryName($category_id); // for display.
		$data_tag = $this->getAllTag();
		return view('topic/newTopic')->with("data_tag",$data_tag);
	}

	public function showViewTopicInCategory($category_id){
		$category_name = $this->getCategoryName($category_id); // for display.

		$sql = "SELECT T.*,U.name,COUNT(C.comment_id) AS count_comment 
				FROM topic T
				LEFT JOIN comment C
				ON T.topic_id = C.topic_id 
				INNER JOIN users U 
				ON T.users_id = U.id and
					 0 < (SELECT COUNT(G.tag_id) 
					 	  FROM tag_topic G
						  WHERE G.topic_id = T.topic_id and
					            G.tag_id IN (SELECT tag_id FROM tag WHERE category_id = $category_id )
							  ) 
				GROUP BY T.topic_id
				ORDER BY T.created_at DESC";

		$data_topic = DB::select($sql);
		$data_topic = $this->arrayMap($data_topic);

		// get tag.
		$i=0;
		foreach($data_topic as $row){
			$data_tag = $this->getTagOnTopic($row['topic_id']);
			$data_topic[$i]['tag'] = $data_tag;
			$i++;
		}
		
		//dd($data_topic);
		
		$this->closeConnectionDB();
		
		//$data_topic = \App\Topic::where('category_id','=',$category_id)->get();
		//dd($data_topic);
		return view('topic/topic_list')	->with("data_topic",$data_topic)
									  	->with("category_id",$category_id)
								 		->with("category_name",$category_name);
	}

	public function getPollChoice($topic_id){
		$sql = "SELECT * FROM poll
				WHERE topic_id = $topic_id ";
		$data_poll_choice = DB::select($sql);
		$data_poll_choice = $this->arrayMap($data_poll_choice);
		$this->closeConnectionDB();
	
		return $data_poll_choice;
	}



	public function showViewTopicBody($topic_id){
		$flag_request = Session::get('flag_request');  // for display modal.
		$flag_add_favorite = Session::get('flag_add_favorite');  // for display modal.
		if(!Auth::guest()){
			$users_id = Auth::user()->id;  // get id user.
		}

		// get data topic.
		$sql = "SELECT T.*,U.name FROM topic T,users U
				WHERE T.users_id = U.id  and topic_id = $topic_id ";
		$data_topic = DB::select($sql);
		$data_topic = $this->arrayMap($data_topic);
		$data_topic = $data_topic[0];

		// get data tag on topic.
		$sql = "SELECT TG.* FROM tag TG,tag_topic TGT
				WHERE TG.tag_id = TGT.tag_id  and TGT.topic_id = $topic_id ";
		$data_tag = DB::select($sql);
		$data_tag = $this->arrayMap($data_tag);

		$this->closeConnectionDB(); // close db.
		
		// get data poll.
		$data_poll_choice = null; // initailize.
		$data_poll_result = null;
		$vote_available = false;

		if($data_topic['topic_type_id'] == 2){  // have poll?

			if(!Auth::guest()){
				$vote_available = $this->canVote($topic_id,$users_id);  // user was vote ? , T/F
				if(!$vote_available){  // user voted. so get stat result of poll.
					$data_poll_result = $this->getResultPoll($topic_id);
				}
			}else{  // guest.
				$vote_available = true; // allow guest see choice poll.
			}
			$data_poll_choice = $this->getPollChoice($topic_id);
		}

		// this method extend from CommentController. 
		// get all data comment in this topic and value vote of comment.
		$data_comment = $this->getAllCommentInTopic($topic_id);  
		$i=0;
		foreach ($data_comment as  $row_comment) {
			$comment_id = $row_comment['comment_id'];

			// this method extend from SubCommentController.
			$data_sub_comment = $this->getAllSubCommentInComment($comment_id);
			$data_comment[$i++]['sub_comment'] = $data_sub_comment;
		}

		//get value vote rating of topic.
		//$data_vote_positive = $this->getVoteRatingPositiveTopic($topic_id);
		//$data_vote_negative = $this->getVoteRatingNegativeTopic($topic_id);
		//$data_vote = $data_vote_positive + $data_vote_negative;
		$data_vote = $this->getSumVoteRatingTopic($topic_id);
		$flag_favorite = true;
		if(!Auth::guest()){
			$flag_favorite = $this->isFavorite($users_id,$topic_id); // for button favorite.
		}
		//dd($flag_favorite);
		// get data topic.
		return view('topic/topic_body')	->with("data_topic",$data_topic)
										->with("data_tag",$data_tag)
										->with("data_comment",$data_comment)
										->with("data_vote",$data_vote)
										->with("data_poll_choice",$data_poll_choice)
										->with("vote_available",$vote_available)
										->with("data_poll_result",$data_poll_result)
										->with("flag_request",$flag_request)
										->with("flag_add_favorite",$flag_add_favorite)
										->with("flag_favorite",$flag_favorite);  
	}

	public function isFavorite($users_id,$topic_id){
		$sql = "SELECT COUNT(*)  AS COUNT 
				FROM favorite_topic 
				WHERE users_id = $users_id and topic_id = $topic_id";
		$flag_favorite = DB::select($sql);
		$flag_favorite = $this->arrayMap($flag_favorite);
		$flag_favorite = $flag_favorite[0]['COUNT'];
		if($flag_favorite <= 0){
			return false;
		}
		return true;
	}

	public function newTopic(){
		$this->auth();
		$title = Input::get('title');
		$body  = Input::get('body');
		$tag   = Input::get('mytag');

		$users_id = Auth::user()->id;

		$topic = new \App\Topic;
		$topic->users_id = $users_id;
		$topic->title = $title;
		$topic->body = nl2br(trim($body));
		$topic->topic_type_id = 1;  // topic conversation.
		$topic->save();

		$topic_id = $topic->id;  // get last id after insert.
		$this->insertTagToTopic($topic_id,$tag);

		Redirect::to('/topic/'.$topic_id.'')->send();
	}

	public function insertTagToTopic($topic_id,$tag){
		foreach ($tag as $row) {
			$tag_topic = new \App\TagTopic;
			$tag_topic->topic_id = $topic_id;
			$tag_topic->tag_id   = $row;
			$tag_topic->save();
		}
	}

	public function getSumVoteRatingTopic($topic_id){
		$sql = "SELECT IFNULL(SUM(V.vote_value),0) AS vote_sum
				FROM vote_useful_topic V
				WHERE topic_id = $topic_id
				";
		$data_vote_sum = DB::select($sql);
		$data_vote_sum = $this->arrayMap($data_vote_sum);
		$data_vote_sum = $data_vote_sum[0];

		$this->closeConnectionDB();
		return $data_vote_sum['vote_sum'];
	}

	public function getVoteRatingPositiveTopic($topic_id){
		$sql = "SELECT IFNULL(SUM(V.vote_value),0) AS vote_positive
				FROM vote_useful_topic V
				WHERE V.vote_value > 0 and topic_id = $topic_id
				";
		$data_vote_positive = DB::select($sql);
		$data_vote_positive = $this->arrayMap($data_vote_positive);
		$data_vote_positive = $data_vote_positive[0];

		$this->closeConnectionDB();
		return $data_vote_positive['vote_positive'];
	}

	public function getVoteRatingNegativeTopic($topic_id){
		$sql = "SELECT IFNULL(SUM(V.vote_value),0) AS vote_negative
				FROM vote_useful_topic V
				WHERE V.vote_value < 0 and topic_id = $topic_id
				";
		$data_vote_negative = DB::select($sql);
		$data_vote_negative = $this->arrayMap($data_vote_negative);
		$data_vote_negative = $data_vote_negative[0];
		//dd($data_vote_negative);
		$this->closeConnectionDB();
		return $data_vote_negative['vote_negative'];
	}

	public function voteRatingTopic($topic_id,$rating_value){
		$users_id = Auth::user()->id; // get id user.

		\App\Vote_useful_topic::where('users_id','=',$users_id)
							  ->where('topic_id','=',$topic_id)->delete();
		//if($count_vote>0){ // user was voted before.

		//}

		if($rating_value == "useful"){
			$this->addVoteRatingTopic($topic_id,1);
		}else{
			$this->addVoteRatingTopic($topic_id,-1);
		}
		
		Redirect::to('/topic/'.$topic_id.'')->send();
	}

	public function addVoteRatingTopic($topic_id,$vote_value){
		$users_id = Auth::user()->id; // get id user.
		$vote = new \App\Vote_useful_topic;
		$vote->topic_id = $topic_id;
		$vote->users_id = $users_id;
		$vote->vote_value = $vote_value;
		$vote->save();
	}

	public function showViewNewTopicPoll(){
		$this->auth();
		//$category_name = $this->getCategoryName($category_id); // for display.
		$data_tag  = $this->getAllTag();
		return view('topic/newPoll')	->with("data_tag",$data_tag);
	}

	public function newPollTopic(){
		$this->auth();
		$title = Input::get('title');
		$body  = Input::get('body');
		$tag  = Input::get('mytag');
		$users_id = Auth::user()->id;

		$topic = new \App\Topic;
		$topic->users_id = $users_id;
		$topic->title = $title;
		$topic->body = nl2br(trim($body));
		$topic->topic_type_id = 2;
		$topic->save();
		$topic_id = $topic->id;  // get last id after insert.

		$this->insertTagToTopic($topic_id,$tag);

		// add poll
		$option_name  = Input::get('option_name');
		$option_detail  = Input::get('option_detail');

		for($i=0;$i<count($option_name);$i++){
			$poll = new \App\Poll;
			$poll->users_id = $users_id;
			$poll->topic_id = $topic_id;
			$poll->name   = $option_name[$i];
			$poll->detail = $option_detail[$i];
			$poll->option_status = "enable";
			$poll->save();
		}


		$topic_id = $topic->id;  // get id after insert.
		Redirect::to('/topic/'.$topic_id.'')->send();
	}


    public function canVote($topic_id,$users_id){
        $sql = "SELECT *
                FROM poll_vote
                WHERE topic_id = $topic_id and users_id = $users_id
                ";

        $data_vote = DB::select($sql);
        $this->closeConnectionDB();
        $data_vote = $this->arrayMap($data_vote);

        if(count($data_vote) > 0){
            return false;
        }
        return true;
    }

    public function getResultPoll($topic_id){

    	$sql = "SELECT P.name, COUNT(V.poll_id) AS vote_count
				FROM poll AS P LEFT OUTER JOIN poll_vote AS V
				ON P.poll_id = V.poll_id AND P.topic_id = $topic_id
				GROUP BY P.poll_id
                ";

        $data_poll_result = DB::select($sql);
        $this->closeConnectionDB();
        $data_poll_result  = $this->arrayMap($data_poll_result );

        return $data_poll_result;
    }

    public function getAllTopicCreatedByUser($users_id){
    	$sql = "SELECT T.*,U.name,COUNT(C.comment_id) AS count_comment 
				FROM topic T
				LEFT JOIN comment C
				ON T.topic_id = C.topic_id 
				INNER JOIN users U 
				ON T.users_id = U.id 
						and T.users_id = $users_id
				GROUP BY T.topic_id
				ORDER BY T.created_at DESC";

        $data_topic = DB::select($sql);
        $this->closeConnectionDB();
        $data_topic  = $this->arrayMap($data_topic);
        return $data_topic;
    }

    public function getAllTopicHaveCommentByUser($users_id){
    	$sql = "SELECT T.*,U.name,COUNT(C.comment_id) AS count_comment 
				FROM topic T
				LEFT JOIN comment C
				ON T.topic_id = C.topic_id 
				INNER JOIN users U 
				ON T.users_id = U.id 
					and C.users_id = $users_id
				GROUP BY T.topic_id
				ORDER BY T.created_at DESC";

		$data_topic_comment = DB::select($sql);
        $this->closeConnectionDB();
        $data_topic_comment  = $this->arrayMap($data_topic_comment);
        return $data_topic_comment;
    }

    // copy from AdminController.
    public function getAllTag(){
		$sql = "SELECT C.category_name,T.*
				FROM category C,tag T
				WHERE C.category_id = T.category_id
				";
		$data_tag = DB::select($sql);
		$data_tag = $this->arrayMap($data_tag);
		return $data_tag;
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

	public function findTopicByName($keyword){
		$sql = "SELECT T.*,U.name,COUNT(C.comment_id) AS count_comment 
				FROM topic T
				LEFT JOIN comment C
				ON T.topic_id = C.topic_id 
				INNER JOIN users U 
				ON T.users_id = U.id 
						and T.title LIKE '%".$keyword."%' or T.body LIKE '%".$keyword."%' 
				GROUP BY T.topic_id
				ORDER BY T.created_at DESC";

        $data_topic = DB::select($sql);
        $this->closeConnectionDB();
        $data_topic  = $this->arrayMap($data_topic);
        return $data_topic;
	}

	public function searchTopic(){
		$keyword = Input::get('keyword');

		// get Topic created by ,
		$data_topic = $this->findTopicByName($keyword); 
		$count_topic = count($data_topic);

		return view('result_search')->with("data_topic",$data_topic)
									->with("count_topic",$count_topic)
									->with("keyword",$keyword);
	}
}
