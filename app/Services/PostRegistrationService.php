<?php

namespace App\Services;

use App\Models\PostRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PostRegistrationService implements RegistrationValidationInterface
{
    /**
     * Create a new post registration.
     *
     * @param array $data
     * @param \App\Models\User $user
     * @return \App\Models\PostRegistration
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createPostRegistration(array $data, User $user): PostRegistration
    {
        $data = $this->validateOnCreate($data);

        if ($user->postregistration()->exists()) {
            $form = $user->postregistration()->first();
            $form->update($data);
        } else {
            $form = new PostRegistration;
            $form->fill($data);
            $user->postregistration()->save($form);
        }

		return $form;
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
            'share_acco' 		=> 'string|nullable',
            'traveling'  		=> 'string',
            'share_travelplans' => 'string|nullable',
            'emergency_name' 	=> 'string',
            'emergency_phone' 	=> 'string',
            'emergency_country' => 'string',
            'dietprefs' 		=> 'string|nullable',
            'shirtsize' 		=> 'string',
            'iccmelse' 			=> 'string|nullable',
            'iccmelse_lastyear' => 'string|nullable',
            'iccmlocation' 		=> 'string|nullable',
            'knowiccm' 			=> 'string|nullable',
            'experince_itman' 	=> 'string|nullable',
            'expert_itman' 		=> 'string|nullable',
            'learn_itman' 		=> 'string|nullable',
            'tech_impl' 		=> 'string|nullable',
            'new_tech' 			=> 'string|nullable',
            'help_worship' 		=> 'string|nullable',
            'speakers' 			=> 'string|nullable',
            'help_iccm' 		=> 'string|nullable'
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
        return $this->validateOnCreate($data);
    }
}


