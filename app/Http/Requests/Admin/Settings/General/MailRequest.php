<?php

namespace App\Http\Requests\Admin\Settings\General;

use Illuminate\{Foundation\Http\FormRequest};

class MailRequest extends FormRequest
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
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'required|string|max:255',
            'mail_from_name' => 'required|string|max:255',
            'mail_from_email' => 'required|email|max:255',
            'mail_encryption' => 'required|in:tls,ssl,none',
        ];
    }
}
