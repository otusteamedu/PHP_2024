<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseNewsRequest extends FormRequest
{
    public function mappedAttributes() {
        $attributeMap = [
            'data.attributes.title' => 'title',
            'data.attributes.body' => 'body',
            'data.attributes.category' => 'category',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updatedAt',
            'data.relationships.author.data.id' => 'user_id'
        ];

        $attributesToUpdate = [];

        foreach($attributeMap as $key => $attribute) {
            if($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }

        return $attributesToUpdate;
    }

    public function messages() {
        return [
            'data.attributes.category' => 'The data.attributes.category value is invalid.Please use Culture,Sport or Politics.'

        ];
    }
}
