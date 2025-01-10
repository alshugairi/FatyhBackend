<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\{Foundation\Http\FormRequest};

class PermissionRequest extends FormRequest
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
        $permissionId = $this->route('permission');

        if ($this->method() === 'POST') {
            $rules['name'] = ['required', 'string', 'max:255', 'unique:permissions'];
        } else {
            $rules['name'] = ['required', 'string', 'max:255', 'unique:permissions,name,' . $permissionId];
        }
        return $rules;
    }
}
