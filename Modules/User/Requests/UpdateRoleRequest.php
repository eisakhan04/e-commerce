<?php

namespace Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:roles,name,' . $this->route('role'),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
