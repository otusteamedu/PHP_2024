<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends BaseNewsRequest
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
        $rules =  [
            'data.attributes.title' => 'sometimes|string',
            'data.attributes.body' => 'sometimes|string',
            'data.attributes.category' => 'sometimes|string|in:Culture,Sport,Politics',
            'data.relationships.author.data.id' => 'sometimes|integer'
        ];

        return $rules;
    }
}
