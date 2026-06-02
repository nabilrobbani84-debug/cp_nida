<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('branches', 'branch_name')->whereNull('deleted_at'),
            ],
            'location' => ['required', 'string', 'max:255'],
        ];
    }
}
