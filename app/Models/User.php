<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','lastname','nickname','passport','gender','residence','email', 'password', 'mail_id', 'checked_out',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
		'role' => 'participant',
	];
    public function accommodation()
    {
        return $this->belongsTo('App\Models\Accommodation');
    }
    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
    public function group()
    {
		return $this->belongsTo('App\Models\Group');
	}
	public function postregistration()
	{
		return $this->hasOne('App\Models\Postregistration');
	}
	public function cost()
	{
		$cost = 0;
		foreach ($this->products as $p)
			$cost += $p->cost;
		return $this->accommodation->cost + $cost;
	}
	public function currencyString() {
		return Currency::def()->format($this->cost());
	}
	public function nameString() {
		$name = "$this->name $this->lastname";
		if ($this->nickname) $name .= " ($this->nickname)";
		return $name;
	}
}
