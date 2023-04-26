<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={"email", "accommodation_id", "name", "lastname", "residence"},
 *     @OA\Xml(name="User"),
 *     @OA\Property(property="id",                type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="name",              type="string", maxLength=255, example="John"),
 *     @OA\Property(property="email",             type="string", format="email", description="User unique email address", example="user@gmail.com"),
 *     @OA\Property(property="email_verified_at", type="string", readOnly="true", format="date-time", description="Datetime marker of verification status", example="2019-02-25 12:59:20"),
 *     @OA\Property(property="role",              type="string", description="User role"),
 *     @OA\Property(property="created_at",        type="string", format="date-time", readOnly="true", example="2018-11-03 12:00:00"),
 *     @OA\Property(property="updated_at",        type="string", format="date-time", readOnly="true", example="2018-11-03 12:00:00"),
 *     @OA\Property(property="accommodation_id",   type="int", example="1"),
 *     @OA\Property(property="group_id",          type="int", example="3"),
 *     @OA\Property(property="lastname",          type="string", maxLength=255, example="Doe"),
 *     @OA\Property(property="nickname",          type="string", maxLength=255, example="Johny"),
 *     @OA\Property(property="passport",          type="string", maxLength=255, description="Name on passport", example="John Doe"),
 *     @OA\Property(property="gender",            type="string", maxLength=1, example="m"),
 *     @OA\Property(property="residence",         type="string", maxLength=255, description="Country of residence", example="CH"),
 *     @OA\Property(property="mail_id",           type="string", maxLength=16, description="Mail ID sent to access post registration", example="0cbd149a0c15b38f"),
 *     @OA\Property(property="checked_out",       type="int", example="0"),
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
        foreach ($this->products as $p) {
            $cost += $p->cost;
        }
        return $this->accommodation->cost + $cost;
    }
    public function currencyString()
    {
        return Currency::def()->format($this->cost());
    }
    public function nameString()
    {
        $name = "$this->name $this->lastname";
        if ($this->nickname) { $name .= " ($this->nickname)";
        }
        return $name;
    }
}
