<?php

namespace App\Http\Requests\Frontend;

use Illuminate\{Foundation\Http\FormRequest};

class ContactRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'captcha' => 'required|string'
        ];
    }

    /**
     * @param $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->captcha != session('captcha_phrase')) {
                $validator->errors()->add('captcha', __('frontend.captcha_error'));
            }
        });
    }
}
