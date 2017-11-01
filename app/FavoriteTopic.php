<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteTopic extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'favorite_id';
	protected $table = 'favorite_topic';
}
