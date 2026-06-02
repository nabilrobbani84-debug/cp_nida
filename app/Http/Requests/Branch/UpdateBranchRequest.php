<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $branch = $this->route('branch');

        return [
            'branch_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('branches', 'branch_name')
                    ->ignore($branch->id_branch, 'id_branch')
                    ->whereNull('deleted_at'),
            ],
            'location' => ['required', 'string', 'max:255'],
        ];
    }
}
