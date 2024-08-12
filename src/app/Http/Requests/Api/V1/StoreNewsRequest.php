<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends BaseNewsRequest
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
        ];

        if($this->routeIs('news.store')) {
            $rules['data.relationships.author.data.id'] = 'required|integer';
        }

        return $rules;
    }
}
