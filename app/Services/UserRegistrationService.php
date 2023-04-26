<?php

namespace App\Services;

use App\Models\Accommodation;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRegistrationService implements RegistrationValidationInterface
{
    /**
     * Register a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $param
     *
     * @return \App\Models\User
     * @throws \Exception
     */
    public function registerUser(array $data, string $role, Group $group): User
    {
        $data = $this->validateOnCreate($data);
        $accommodation = Accommodation::find($data['accommodation']);
        $user = new User();
        $user->fill(
            [
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'nickname' => $data['nickname'],
            'passport' => $data['passport'],
            'gender' => $data['gender'],
            'residence' => $data['residence'],
            'email' => $data['email'],
            'mail_id' => bin2hex(random_bytes(8)),
            'password' => Hash::make($data['password'] ?? bin2hex(random_bytes(8))) // Prevents empty password
            ]
        );
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
        DB::transaction(
            function () use ($group, $user, $ids) {
                $group->save();
                $group->users()->save($user);
                $user->products()->sync($ids);
            }
        );

        return $user;
    }

    /**
     * Validate add user request.
     *
     * @param  array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOnCreate(array $data): array
    {
        return Validator::make(
            $data,
            [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'nickname' => ['string', 'max:255'],
            'passport' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'residence' => ['required', 'string', 'max:255'],
            'accommodation' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]
        )->validate();
    }

    /**
     * Validate registration request.
     *
     * @param  array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOnUpdate(array $data): array
    {
        return Validator::make(
            $data,
            [
            'name' => ['string', 'max:255'],
            'lastname' => ['string', 'max:255'],
            'nickname' => ['string', 'max:255'],
            'passport' => ['string', 'max:255'],
            'gender' => ['max:1'],
            'residence' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['string', 'min:8', 'confirmed'],
            ]
        )->validate();
    }
}
