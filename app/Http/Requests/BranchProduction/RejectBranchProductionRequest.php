<?php

namespace App\Http\Requests\BranchProduction;

use Illuminate\Foundation\Http\FormRequest;

class RejectBranchProductionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdminPusat() ?? false;
    }

    public function rules(): array
    {
        return [
            'notes' => ['required', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'notes.required' => 'Alasan penolakan wajib diisi.',
        ];
    }
}
