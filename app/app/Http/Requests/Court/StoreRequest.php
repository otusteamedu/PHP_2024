<?php

namespace App\Http\Requests\Court;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        return [
            'name' => 'required|string',
            'address' => 'required|string',
            'region_id' => 'string',
            'cass_region' => 'required|string',
            'general_type_id' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email',
            'site' => 'required|url',
        ];
    }
}
