<?php

namespace App\Http\Requests\Admin\Finance;

use App\Enums\TransactionType;
use Illuminate\{Foundation\Http\FormRequest, Validation\Rule};

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference_type' => ['required', Rule::in(TransactionType::values())],
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'details' => 'nullable|string',
            'notes' => 'nullable|string'
        ];
    }
}
