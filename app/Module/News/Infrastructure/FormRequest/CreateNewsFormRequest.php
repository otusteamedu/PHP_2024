<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\FormRequest;

use Illuminate\Foundation\Http\FormRequest;
use Module\News\Application\UseCase\Create\CreateRequest;

final class CreateNewsFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => ['required', 'url']
        ];
    }

    public function toUseCaseRequest(): CreateRequest
    {
        return new CreateRequest($this->validated('url'));
    }
}
