<?php

namespace Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:permissions,name',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
