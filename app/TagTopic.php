<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TagTopic extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'tag_topic_id';
	protected $table = 'tag_topic';
}
