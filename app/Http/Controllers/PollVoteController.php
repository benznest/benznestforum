<?php namespace App\Http\Controllers;
use Input; 
use Redirect;
use Auth;

class PollVoteController extends Controller {

	public function addVote(){

        $topic_id = Input::get('topic_id');
        $choice = Input::get('choice');  // array input
        $users_id = Auth::user()->id;

        foreach ($choice as $poll_id){
            $vote = new \App\PollVote;
            $vote->users_id = $users_id;
            $vote->topic_id = $topic_id;
            $vote->poll_id = $poll_id;
            $vote->save();
        }

        Redirect::to('/topic/'.$topic_id.'')->send();
    }


}
