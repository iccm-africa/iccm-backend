<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={"travelling", "emergency_name", "emergency_phone", "emergency_country", "shirtsize"},
 *     @OA\Xml(name="User"),
 *     @OA\Property(property="id",                type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="created_at",        type="string", format="date-time", readOnly="true", example="2018-11-03 12:00:00"),
 *     @OA\Property(property="updated_at",        type="string", format="date-time", readOnly="true", example="2018-11-03 12:00:00"),
 *     @OA\Property(property="user_id",           type="int", description="User ID", example="2"),
 *     @OA\Property(property="share_acco",        type="string", description="Share accommodation with", example="My friend Bob"),
 *     @OA\Property(property="traveling",         type="string", format="string", description="Where is person travelling from", example="Basel"),
 *     @OA\Property(property="share_travelplans", type="string", maxLength=255, description="How the person is travelling", example="by car"),
 *     @OA\Property(property="emergency_name",    type="string", maxLength=255, description="Emergency Contact", example="John Doe"),
 *     @OA\Property(property="emergency_phone",   type="string", maxLength=255, example="123456789"),
 *     @OA\Property(property="emergency_country", type="string", maxLength=255, example="Switzerland"),
 *     @OA\Property(property="dietprefs",         type="string", maxLength=255, description="Diet preferences / Special needs", example="lactose free"),
 *     @OA\Property(property="shirtsize",         type="string", maxLength=1, description="Size of the shirt", example="L"),
 *     @OA\Property(property="iccmelse",          type="string", maxLength=255,  description="Has visited ICCM before", example="Yes"),
 *     @OA\Property(property="iccmelse_lastyear", type="string", maxLength=255,  description="Year of last ICCM visit", example="2022"),
 *     @OA\Property(property="iccmlocation",      type="string", maxLength=255,  description="Location of last ICCM visit", example="EUROPE"),
 *     @OA\Property(property="knowiccm",          type="string", description="How person found out about ICCM", example="Internet"),
 *     @OA\Property(property="experince_itman",   type="string", description="IT Experience", example="Drupal Developer"),
 *     @OA\Property(property="expert_itman",      type="string", description="Is an expert in", example="Drupal"),
 *     @OA\Property(property="learn_itman",       type="string", description="Wants to learn about", example="Laravel"),
 *     @OA\Property(property="tech_impl",         type="string", description="Plans to implement in coming year", example="Upgrade to Drupal 10"),
 *     @OA\Property(property="new_tech",          type="string", description="Wants to know more about", example="NextJS"),
 *     @OA\Property(property="help_worship",      type="string", description="Wants to join the band", example="Playing piano"),
 *     @OA\Property(property="speakers",          type="string", description="Can share a devotion", example="No, sorry."),
 *     @OA\Property(property="help_iccm",         type="string", description="Can help with ICCM", example="Can help with setup")
 * )
 */
class PostRegistration extends Model
{
    use Notifiable;

    public function user()
    {
          return $this->belongsTo('App\Models\User');
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
