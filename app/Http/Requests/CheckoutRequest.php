<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'regex:/^(?:\\+62|62|0)8[1-9][0-9]{6,11}$/'],
            'customer_address' => ['required', 'string', 'max:2000'],
        ];
    }

    /**
     * Sanitize input before validation or after.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'customer_name' => trim(strip_tags((string) $this->input('customer_name'))),
            'customer_phone' => preg_replace('/\\s+/', '', strip_tags((string) $this->input('customer_phone'))),
            'customer_address' => trim(strip_tags((string) $this->input('customer_address'))),
        ]);
    }
}
