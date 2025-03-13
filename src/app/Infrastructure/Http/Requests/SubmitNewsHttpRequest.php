<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitNewsHttpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => 'required|string|url'
        ];
    }
}
