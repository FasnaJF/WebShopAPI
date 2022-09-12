<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => 0,
                'error' => 'Failed Validation',
                'errors' => $validator->errors(),
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    protected function resourceNotFound($message)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => 0,
                'error' => $message,
                'errors' => [],
            ], ResponseAlias::HTTP_NOT_FOUND)
        );
    }

    protected function unauthorizedError()
    {
        throw new HttpResponseException(
            response()->json([
                'success' => 0,
                'error' => 'Unauthorized',
                'errors' => [],
            ], ResponseAlias::HTTP_UNAUTHORIZED)
        );
    }
}
