<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'company' => 'required|string|max:50',
            'address' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $this->id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'company.required' => 'Company is required',
            'address.required' => 'Address is required',
            'phone.required' => 'Phone is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email is already taken',
        ];
    }
}
