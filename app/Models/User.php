<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={"password"},
 *     @OA\Xml(name="User"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="role", type="string", readOnly="true", description="User role"),
 *     @OA\Property(property="email", type="string", readOnly="true", format="email", description="User unique email address", example="user@gmail.com"),
 *     @OA\Property(property="email_verified_at", type="string", readOnly="true", format="date-time", description="Datetime marker of verification status", example="2019-02-25 12:59:20"),
 *     @OA\Property(property="name", type="string", maxLength=255, example="John"),
 *     @OA\Property(property="lastname", type="string", maxLength=255, example="Doe"),
 *     @OA\Property(property="nickname", type="string", maxLength=255, example="Johny"),
 *     @OA\Property(property="passport", type="string", maxLength=32, example="123456789"),
 *     @OA\Property(property="gender", type="string", maxLength=1, example="m"),
 *     @OA\Property(property="residence", type="string", maxLength=255, example="Vilnius"),
 * )
 */
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
		return $this->hasOne('App\Models\PostRegistration');
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
