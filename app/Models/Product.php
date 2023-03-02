<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table='products';
	protected $fillables=['name','description','cost'];
	public function participants()
	{
		return $this->belongsToMany('App\Models\User');
	}
}
