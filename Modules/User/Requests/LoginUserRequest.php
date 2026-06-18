<?php

namespace Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'password' => 'required|string',
        ];
    }
}
