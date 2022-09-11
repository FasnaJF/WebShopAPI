<?php

namespace App\Http\Requests;

class RegisterRequest extends BaseRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => 'required|required_with:password_confirmation|same:password_confirmation|min:8',
            'password_confirmation' => 'min:8',
            'job_title' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ];
    }

}
