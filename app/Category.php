<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'category_id';
	protected $table = 'category';
}
