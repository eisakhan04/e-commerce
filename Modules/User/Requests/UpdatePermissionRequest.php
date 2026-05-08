<?php

namespace Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:permissions,name,' . $this->route('permission'),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
