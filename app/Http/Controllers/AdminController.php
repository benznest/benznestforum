<?php namespace App\Http\Controllers;
use Input; 
use DB;
use Auth;
use Redirect;
use Session;

class AdminController extends Controller {

	public function __construct()
	{
		if(Auth::guest()){
			Redirect::to('auth\login')->send();
		}else{
			if(Auth::user()->level!="admin"){
				Redirect::to('auth\login')->send();
			}
		}
	}


	public function arrayMap($transactions){
		return array_map(function($object){
    		return (array) $object;
		}, $transactions);
	}

	public function getAllCategory(){
		$sql = "SELECT C.*
				FROM category C
				";
		$data_category = DB::select($sql);
		$data_category = $this->arrayMap($data_category);
		return $data_category;
	}

	public function getAllCategoryAndTotalTag(){
		$sql = "SELECT C.*,COUNT(T.tag_id) AS count_tag
				FROM category C
				LEFT JOIN tag T
				ON T.category_id = C.category_id
				GROUP BY category_id
				";
		$data_category = DB::select($sql);
		$data_category = $this->arrayMap($data_category);
		return $data_category;
	}

	public function getAllTag(){
		$sql = "SELECT C.category_name,T.*
				FROM category C,tag T
				WHERE C.category_id = T.category_id
				";
		$data_tag = DB::select($sql);
		$data_tag = $this->arrayMap($data_tag);
		return $data_tag;
	}



	public function showViewGeneralManagemane(){
		$forum_name = ConfigForumController::getForumName();
		return view('auth/admin/general_management')->with("admin_tab","general")
													->with("forum_name",$forum_name );
	}

	public function showViewTagManagement(){

		$msg         = Session::get('msg');
		$status      = Session::get('status');

		$data_category = $this->getAllCategory();
		$data_tag = $this->getAllTag();

		return view('auth/admin/tag_management')->with("admin_tab","tag")
												->with("data_category",$data_category)
												->with("data_tag",$data_tag)
												->with("msg",$msg)
								   		  		->with("status",$status);
	}

	public function showViewCategoryManagement(){

		$msg         = Session::get('msg');
		$status      = Session::get('status');

		//$data_category = $this->getAllCategory();
		$data_category = $this->getAllCategoryAndTotalTag();
		return view('auth/admin/category_management')->with("admin_tab","category")
													 ->with("data_category",$data_category)
													 ->with("msg",$msg)
								   		  			 ->with("status",$status);
	}

	public function showViewAccountManagement(){

		$msg         = Session::get('msg');
		$status      = Session::get('status');


		$sql = "SELECT U.*
				FROM users U
				";
		$data_users = DB::select($sql);
		$data_users  = $this->arrayMap($data_users);
		return view('auth/admin/account_management')->with("admin_tab","account")
													->with("data_users",$data_users)
													->with("msg",$msg)
								   		  			->with("status",$status);
	
	}

	public function showViewRequestManagement(){
		$msg         = Session::get('msg');
		$status      = Session::get('status');


		$sql = "SELECT R.*
				FROM request R
				";
		$data_request = DB::select($sql);
		$data_request  = $this->arrayMap($data_request);
		//dd($data_request);
		return view('auth/admin/request_management')->with("admin_tab","request")
													->with("data_request",$data_request)
													->with("msg",$msg)
								   		  			->with("status",$status);
	
	}

	public function showViewTopicManagement(){
		$sql = "SELECT T.*
				FROM topic T
				";
		$data_topic = DB::select($sql);
		$data_topic  = $this->arrayMap($data_topic);
		return view('auth/admin/topic_management')->with("admin_tab","topic")
												  ->with("data_topic",$data_topic);
	}

	public function showViewStatistics(){
		// $sql = "SELECT T.*
		// 		FROM topic T
		// 		";
		// $data_topic = DB::select($sql);
		// $data_topic  = $this->arrayMap($data_topic);
		return view('auth/admin/statistic')->with("admin_tab","statistics");
	}




	public function changeForumName(){
		$forum_name = Input::get('forum_name');
		$sql = "UPDATE config_forum SET forum_name = '$forum_name'";
		DB::select($sql);

		Redirect::to('admin/general')->send();
	}

	public function addCategory(){
		$category_name   = Input::get('category_name');
		$category_status = Input::get('category_status');

		$category = new \App\Category;
		$category->category_name = $category_name;
		$category->category_status = $category_status;
		$category->save();

		return redirect('/admin/category')->with("msg","successful")
								   		  ->with("status","success");
	}

	public function editCategory(){
		$category_id     = Input::get('category_id');
		$category_name   = Input::get('category_name');
		$category_status = Input::get('category_status');

		$category = \App\Category::where('category_id',$category_id)->first();

		$category->category_name   = $category_name;
		$category->category_status = $category_status;
		$category->save();

		//$sql = "UPDATE category SET category_name = '$categiory_name' , 
		//							category_status = '$category_status'
		//						WHERE category_id = $category_id";
		//DB::select($sql);

		return redirect('/admin/category')->with("msg","successful")
								   		  ->with("status","success");
	}

	public function addtag(){
		$tag_name   = Input::get('tag_name');
		$tag_status = Input::get('tag_status');
		$category_id = Input::get('category_id');;

		$tag = new \App\Tag;
		$tag->category_id   = $category_id;
		$tag->tag_name      = $tag_name;
		$tag->tag_status    = $tag_status;
		$tag->save();

		return redirect('/admin/tag')->with("msg","successful")
								   	 ->with("status","success");
	}

	public function editTag(){
		$tag_id     = Input::get('tag_id');
		$tag_name   = Input::get('tag_name');
		$tag_status = Input::get('tag_status');
		$category_id = Input::get('category_id');

		$tag = \App\Tag::where('tag_id',$tag_id)->first();

		$tag->tag_name   = $tag_name;
		$tag->tag_status = $tag_status;
		$tag->category_id = $category_id;
		$tag->save();

		return redirect('/admin/tag')->with("msg","successful")
								     ->with("status","success");
	}

	public function banAccount(){
		$users_id     = Input::get('users_id');
		$users_name   = Input::get('users_name');

		$user = \App\User::where('id',$users_id)->first();
		$user->status   = "banned";
		$user->save();

		return redirect('/admin/account')->with("msg","$users_name is banned.")
								         ->with("status","success");
	}

	public function recoverAccount(){
		$users_id     = Input::get('users_id');
		$users_name   = Input::get('users_name');

		$user = \App\User::where('id',$users_id)->first();
		$user->status   = "active";
		$user->save();

		return redirect('/admin/account')->with("msg","$users_name is come back.")
								         ->with("status","success");
	}
}

