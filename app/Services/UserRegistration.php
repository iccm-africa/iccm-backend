<?php

namespace App\Services;

use App\Models\Accommodation;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRegistration
{
    /**
     * Register a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $param
     *
     * @return \App\Models\User
     * @throws \Exception
     */
    public function registerUser(array $data, string $role, ?Group $group=NULL): User
    {
        if (!$group) {
            $group = $this->getGroup($data);
        }
        $accommodation = Accommodation::find($data['accommodation']);
        $user = new User;
        $user->fill([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'nickname' => $data['nickname'],
            'passport' => $data['passport'],
            'gender' => $data['gender'],
            'residence' => $data['residence'],
            'email' => $data['email'],
            'mail_id' => bin2hex(random_bytes(8)),
            'password' => Hash::make($data['password']),
            'role' => $role,
        ]);
        $user->accommodation()->associate($accommodation);
        $keys = array_keys($data);
        $ids = [];
        foreach ($keys as $k) {
            if (preg_match("/^product_([0-9]+)$/", $k, $matches) === 1) {
                $ids[] = $matches[1];
            }
        }
        DB::transaction(function () use ($group, $user, $ids) {
            $group->save();
            $group->users()->save($user);
            $user->products()->sync($ids);
        });

        return $user;
    }

    /**
     * Validate the form.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function form_validate($request): void
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'passport' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'residence' => ['required', 'string', 'max:255'],
            'accommodation' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
    }

    /**
     * @param array $data
     *
     * @return \App\Models\Group
     */
    public function getGroup(array $data): Group
    {
        $group = new Group;
        $group->fill([
            'name' => $data['organisation'],
            'website' => $data['website'],
            'org_type' => $data['orgtype'] == 'other' ? $data['orgtypeother'] : $data['orgtype'],
            'address' => $data['address'],
            'town' => $data['town'],
            'state' => $data['state'],
            'zipcode' => $data['zipcode'],
            'country' => $data['country'],
            'telephone' => $data['telephone'],
        ]);

        return $group;
    }
}
