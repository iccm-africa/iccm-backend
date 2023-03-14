<?php

namespace App\Services;

interface RegistrationValidationInterface
{
    /**
     * Validate registration request.
     *
     * @param array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOnCreate(array $data): array;

    /**
     * Validate registration request.
     *
     * @param array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOnUpdate(array $data): array;
}
