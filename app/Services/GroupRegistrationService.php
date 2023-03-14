<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Support\Facades\Validator;

class GroupRegistrationService extends UserRegistrationService implements RegistrationValidationInterface
{
    /**
     * Validate and register a new user as a group.
     *
     * @param array $data
     * @param string $role
     * @return \App\Models\User
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function registerGroup(array $data, string $role): \App\Models\User
    {
        $data = $this->validateOnCreate($data);
        $group = $this->createGroup($data);
        return parent::registerUser($data, $role, $group);
    }

    /**
     * Create a new group.
     *
     * @param array $data
     * @return \App\Models\Group
     */
    public function createGroup(array $data): Group
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
    public function validateOnCreate(array $data): array
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
     * Validate update request.
     *
     * @param array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOnUpdate(array $data): array
    {
        return Validator::make($data, [
            'organisation' => ['string', 'max:255'],
            'orgtype' => ['string', 'max:255'],
            'orgtypeother' => $data['orgtype'] == 'other'? ['string', 'max:255'] : '',
            'address' => ['string', 'max:255'],
            'town' => ['string', 'max:255'],
            'zipcode' => ['string', 'max:255'],
            'country' => ['string', 'max:255'],
            'telephone' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
        ])->validate();
    }
}
