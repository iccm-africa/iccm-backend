<?php

namespace App\Http\Controllers\Api;

use App\Services\RegistrationValidationInterface;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="ICCM Backend API", version="0.1")
 */
class Controller
{
    /**
     * Validate request before updating a resource.
     *
     * @param $request
     * @param $user
     * @param \App\Services\RegistrationValidationInterface $registrationService
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    protected function validateBeforeUpdate($request, Model $model, RegistrationValidationInterface $registrationService): array
    {
        if ($request->getMethod() == 'PATCH') {
            $data = $registrationService->validateOnUpdate($request->all());
        } else {
            $data = $this->fillMissingFields($request->all(), $model->getFillable(), '');
            $data =  $registrationService->validateOnReplace($data);
        }
        if (empty($data)) {
            throw new \Exception('Body contains no or invalid data');
        }
        return $data;
    }

    /**
     * Fill all fillable fields with null or other default value if not present
     *
     * @param $data
     * @param $fields
     * @param $default
     * @return array
     */
    protected function fillMissingFields($data, $fields, $default = null): array
    {
        foreach ($fields as $field) {
            if (!isset($data[$field])) {
                $data[$field] = '';
            }
        }
        return $data;
    }
}
