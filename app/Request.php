<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'request_id';
	protected $table = 'request';
}
