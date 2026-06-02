<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isSuperAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'code')->whereNull('deleted_at'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'id_product_type' => [
                'required',
                'integer',
                Rule::exists('product_types', 'id_product_type')->whereNull('deleted_at'),
            ],
            'id_unit' => [
                'required',
                'integer',
                Rule::exists('units', 'id_unit')->whereNull('deleted_at'),
            ],
            'hs_code' => ['nullable', 'string', 'max:20'],
        ];
    }
}