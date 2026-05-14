<?php

namespace Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $permissionId = $this->route('permission') ?? $this->route('id');

        if ($this->isMethod('post')) {
            return [
                'name' => 'required|string|unique:permissions,name',
            ];
        }

        return [
            'name' => 'sometimes|string|unique:permissions,name,' . $permissionId,
        ];
    }
}
