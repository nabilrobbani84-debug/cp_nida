<?php

namespace App\Http\Requests\ProductType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productType = $this->route('product_type');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_types', 'name')
                    ->ignore($productType->id_product_type, 'id_product_type')
                    ->whereNull('deleted_at'),
            ],
        ];
    }
}
