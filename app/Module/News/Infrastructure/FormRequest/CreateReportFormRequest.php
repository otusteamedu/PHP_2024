<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\FormRequest;

use Illuminate\Foundation\Http\FormRequest;
use Module\News\Application\UseCase\CreateReport\CreateReportRequest;

final class CreateReportFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ids' => ['array', 'required'],
            'ids.*' => ['required', 'uuid']
        ];
    }

    public function toUseCaseRequest(): CreateReportRequest
    {
        return new CreateReportRequest(...$this->validated('ids'));
    }
}
