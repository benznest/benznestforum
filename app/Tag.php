<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'tag_id';
	protected $table = 'tag';
}
