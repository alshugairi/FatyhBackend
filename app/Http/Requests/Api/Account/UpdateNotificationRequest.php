<?php

namespace App\Http\Requests\Api\Account;

use Illuminate\{Foundation\Http\FormRequest};

class UpdateNotificationRequest extends FormRequest
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
            'notify_email'    => ['required', 'boolean'],
            'notify_sms'      => ['required', 'boolean'],
            'notify_whatsapp' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'notify_email'    => $this->notify_email ?? 0,
            'notify_sms'      => $this->notify_sms ?? 0,
            'notify_whatsapp' => $this->notify_whatsapp ?? 0,
        ]);
    }
}
