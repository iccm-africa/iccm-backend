<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $table='groups';
	protected $fillable=['name','website','org_type','address','town','state','zipcode','country','telephone','checked_out'];

    protected $attributes = [
        'checked_out' => 0,
    ];
	public function users()
	{
		return $this->hasMany('App\User');
	}
	public function invoices()
	{
		return $this->hasMany('App\Invoice');
	}
	public function admin()
	{
		return $this->users()->where(function ($q) {
			return $q->where('role', 'groupadmin')->orWhere('role', 'admin');
		})->first();
	}

/*
	public function product()
	{
		return $this->hasMany('App\Product');
	}
*/
	public function cost()
	{
		$cost = 0;
		foreach ($this->users as $u)
			$cost += $u->cost();
		return $cost;
	}
	public function outstanding()
	{
		$invoiced = 0;
		foreach($this->invoices as $i)
			$invoiced += $i->amount;
		return $this->cost() - $invoiced;
	}
}
