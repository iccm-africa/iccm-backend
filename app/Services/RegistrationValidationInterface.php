<?php

namespace App\Services;

interface RegistrationValidationInterface
{
    /**
     * Validate registration request on POST.
     *
     * @param  array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOnCreate(array $data): array;

    /**
     * Validate registration request on PATCH.
     *
     * @param  array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOnUpdate(array $data): array;

    /**
     * Validate registration request on PUT.
     *
     * @param  array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOnReplace(array $data): array;
}
