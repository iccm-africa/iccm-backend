<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Postregistration extends Model
{
    use Notifiable;

	public function user()
 	{
          return $this->belongsTo('App\User');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table='postregistrations';
    protected $fillable = [
		'share_acco', 'traveling', 'share_travelplans', 'emergency_name', 'emergency_phone', 'emergency_country', 'dietprefs', 'shirtsize', 'iccmelse', 'iccmelse_lastyear', 'iccmlocation', 'knowiccm', 'experince_itman', 'expert_itman', 'learn_itman', 'tech_impl', 'new_tech', 'help_worship', 'speakers', 'help_iccm', 'ticket_path',
    ];


}
