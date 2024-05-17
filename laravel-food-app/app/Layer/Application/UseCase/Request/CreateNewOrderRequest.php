<?php

declare(strict_types=1);

namespace App\Layer\Application\UseCase\Request;


use Illuminate\Foundation\Http\FormRequest;

class CreateNewOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order' => 'required'
        ];
    }
}
