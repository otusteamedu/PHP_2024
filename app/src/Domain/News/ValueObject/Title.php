<?php

declare(strict_types=1);

namespace Valen\App\Domain\News\ValueObject;

readonly class Title
{
    public function __construct(
        public string $title
    ) {
        $this->validate($title);
    }

    private function validate(string $title): void
    {
        // Проверка на пустое значение
        if (empty(trim($title))) {
            throw new \InvalidArgumentException('Заголовок не может быть пустым');
        }

        // Проверка минимальной длины
        if (mb_strlen($title) < 3) {
            throw new \InvalidArgumentException('Заголовок должен содержать не менее 3 символов');
        }

        // Проверка максимальной длины
        if (mb_strlen($title) > 255) {
            throw new \InvalidArgumentException('Заголовок не должен превышать 255 символов');
        }

        // Дополнительная проверка на запрещенные символы (опционально)
        // Например, проверка на отсутствие HTML-тегов или специальных символов
        if (preg_match('/<.*>/', $title)) {
            throw new \InvalidArgumentException('Заголовок не должен содержать HTML-теги');
        }
    }
}
