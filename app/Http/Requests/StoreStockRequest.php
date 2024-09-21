<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
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
            'code' => 'required|string|max:50|unique:stocks,code,' . $this->id,
            'name' => 'required|string|max:50',
            'image' => 'nullable|image|max:10240', // max size in KB (10MB)
            'description' => 'nullable|string',
            'sizes' => 'required|array|min:1',
            'sizes.*.size' => 'required|string|max:50|distinct',
            'sizes.*.quantity' => 'required|integer|min:0',

        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Item code is required',
            'name.required' => 'Item name is required',
            'sizes.required' => 'Sizes are required',
            'sizes.*.size.required' => 'Size is required',
            'sizes.*.quantity.required' => 'Size quantity is required',
            'sizes.*.quantity.integer' => 'Size quantity must be an integer',
            'sizes.*.quantity.min' => 'Size quantity must be at least 0',
            'sizes.*.size.distinct' => 'Duplicate sizes are not allowed',
        ];
    }
}
