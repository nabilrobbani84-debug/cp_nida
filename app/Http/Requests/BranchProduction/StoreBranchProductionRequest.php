<?php

namespace App\Http\Requests\BranchProduction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBranchProductionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isOperatorProduksi() ?? false;
    }

    public function rules(): array
    {
        return [
            'production_date' => ['required', 'date'],
            'id_product' => [
                'required',
                'integer',
                Rule::exists('products', 'id_product')->whereNull('deleted_at'),
            ],
            'good_products' => ['required', 'integer', 'min:0'],
            'rejected_products' => ['required', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
