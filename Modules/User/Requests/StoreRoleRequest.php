<?php

namespace Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:roles,name',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
