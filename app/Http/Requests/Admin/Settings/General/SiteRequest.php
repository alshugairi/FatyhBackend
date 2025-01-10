<?php

namespace App\Http\Requests\Admin\Settings\General;

use Illuminate\{Foundation\Http\FormRequest};

class SiteRequest extends FormRequest
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
            'site_date_format' => 'required|string|max:255',
            'site_time_format' => 'required|string|max:255',
            'site_currency_id' => 'required|integer',
            'site_currency_position' => 'required|in:left,right',
            'site_precision' => 'required|integer',
            'site_android_app_link' => 'nullable|string|max:255',
            'site_ios_app_link' => 'nullable|string|max:255',
        ];
    }
}
