<?php

namespace App\Http\Requests\Admin\Settings\General;

use Illuminate\{Foundation\Http\FormRequest};

class CompanyRequest extends FormRequest
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
        return [
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'required|string|max:15',
            'company_website' => 'nullable|url|max:255',
            'company_zip_code' => 'required|string|max:10',
            'company_address' => 'required|string|max:500',
        ];
    }
}
