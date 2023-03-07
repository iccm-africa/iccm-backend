<?php

namespace App\Services;

use App\Models\Accommodation;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            $data = $this->validateRegistration($data);
            $group = $this->getGroup($data);
        } else {
            $data = $this->validateUserAdd($data);
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
            'password' => Hash::make($data['password'] ?? bin2hex(random_bytes(8))) // Prevents empty password
        ]);
        if ($role != 'participant') {
            $user->role = $role;
        }
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

    /**
     * Validate registration request.
     *
     * @param array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateRegistration(array $data): array
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'nickname' => ['string', 'max:255'],
            'passport' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'residence' => ['required', 'string', 'max:255'],
            'organisation' => ['required', 'string', 'max:255'],
            'orgtype' => ['required', 'string', 'max:255'],
            'orgtypeother' => $data['orgtype'] == 'other'? ['required', 'string', 'max:255'] : '',
            'address' => ['required', 'string', 'max:255'],
            'town' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'accommodation' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();
    }

    /**
     * Validate add user request.
     *
     * @param array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateUserAdd(array $data): array
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'nickname' => ['string', 'max:255'],
            'passport' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'residence' => ['required', 'string', 'max:255'],
            'accommodation' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ])->validate();
    }

    /**
     * Validate registration request.
     *
     * @param array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOnUserUpdate(array $data): array
    {
        return Validator::make($data, [
            'name' => ['string', 'max:255'],
            'lastname' => ['string', 'max:255'],
            'nickname' => ['string', 'max:255'],
            'passport' => ['string', 'max:255'],
            'gender' => ['max:1'],
            'residence' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['string', 'min:8', 'confirmed'],
        ])->validate();
    }
}
