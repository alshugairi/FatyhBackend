<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\{Foundation\Http\FormRequest};

class CurrencyRequest extends FormRequest
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
        $currency = $this->route('currency');

        return [
            'name' => 'required|array',
            'name.*' => 'required|string|max:255',
            'code' => 'required|string|unique:currencies,code,' . $currency?->id,
            'symbol' => 'required|max:255',
            'exchange_rate' => 'required|numeric',
        ];
    }
}
