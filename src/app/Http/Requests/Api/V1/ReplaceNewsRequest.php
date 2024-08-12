<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ReplaceNewsRequest extends BaseNewsRequest
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
            'data.attributes.title' => 'required|string',
            'data.attributes.body' => 'required|string',
            'data.attributes.category' => 'required|string|in:Culture,Sport,Politics',
            'data.relationships.author.data.id' => 'required|integer'
        ];

        return $rules;
    }

    public function messages() {
        return [
            'data.attributes.category' => 'The data.attributes.category value is invalid.Please use Culture,Sport or Politics.'

        ];
    }
}
