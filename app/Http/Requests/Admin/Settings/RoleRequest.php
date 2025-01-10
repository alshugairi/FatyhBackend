<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\{Foundation\Http\FormRequest};

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $role = $this->route('role');

        $rules['name'] = ['required', 'string', 'max:255', 'unique:roles,name,' . $role?->id];
        $rules['role_permissions'] = ['required','array'];
        $rules['role_permissions.*'] = ['required','string','exists:permissions,name'];
        return $rules;
    }
}
