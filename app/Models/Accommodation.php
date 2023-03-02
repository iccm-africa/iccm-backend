<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
	protected $table='accommodations';
	protected $fillable=['name','description','cost'];
	public function users()
	{
		return $this->hasMany('App\Models\User');
	}
}
