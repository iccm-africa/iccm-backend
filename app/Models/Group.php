<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     required={"name", "org_type", "address", "town", "state", "zipcode", "country", "telephone"},
 *     @OA\Xml(name="Group"),
 *     @OA\Property(property="id",                type="integer", readOnly="true", example="3"),
 *     @OA\Property(property="created_at",        type="string", format="date-time", readOnly="true", example="2018-11-03 12: 00: 00"),
 *     @OA\Property(property="updated_at",        type="string", format="date-time", readOnly="true", example="2018-11-03 12: 00: 00"),
 *     @OA\Property(property="name",              type="string", maxLength=255, description="Name of the organistion/group", example="Organization XYZ"),
 *     @OA\Property(property="website",           type="string", maxLength=255, description="Website of the organsiation", example="www.xyz-international.org"),
 *     @OA\Property(property="org_type",          type="string", maxLength=255, description="Type of organisation", example="Mission Agency"),
 *     @OA\Property(property="address",           type="string", maxLength=255, description="Street", example="Street 1"),
 *     @OA\Property(property="town",              type="string", maxLength=255, description="Town", example="Zurich"),
 *     @OA\Property(property="state",             type="string", maxLength=255, description="State", example="ZH"),
 *     @OA\Property(property="zipcode",           type="string", maxLength=255, description="Zipcode", example="12345"),
 *     @OA\Property(property="country",           type="string", maxLength=255, description="Country", example="CH"),
 *     @OA\Property(property="telephone",         type="string", maxLength=255, description="Telephone", example="123456789"),
 *     @OA\Property(property="checked_out",       type="int", example="0")
 * )
 */
class Group extends Model
{
    protected $table='groups';
    protected $fillable=['name','website','org_type','address','town','state','zipcode','country','telephone','checked_out'];

    protected $attributes = [
        'checked_out' => 0,
    ];
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }
    public function admin()
    {
        return $this->users()->where(
            function ($q) {
                return $q->where('role', 'groupadmin')->orWhere('role', 'admin');
            }
        )->first();
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
        foreach ($this->users as $u) {
            $cost += $u->cost();
        }
        return $cost;
    }
    public function outstanding()
    {
        $invoiced = 0;
        foreach($this->invoices as $i) {
            $invoiced += $i->amount;
        }
        return $this->cost() - $invoiced;
    }
}
