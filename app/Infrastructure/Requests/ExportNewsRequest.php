<?php

namespace App\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:news,id'],
        ];
    }
}
