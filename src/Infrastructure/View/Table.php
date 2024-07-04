<?php

declare(strict_types=1);

namespace App\Infrastructure\View;

use App\Domain\Entity\BookCollection;

class Table
{
    private array $headers;
    private BookCollection $rows;

    public function __construct(BookCollection $rows)
    {
        $this->rows = $rows;
        $this->headers = ['Название', 'Категория', 'Цена', 'Наличие'];
    }


    public function render(): void
    {
        if ($this->rows->count() == 0) {
            echo "Книги не найдены.\n";
            return;
        }

        $this->renderLine($this->headers);
        foreach ($this->rows as $book) {
            $this->renderLine([
                $book->title,
                $book->category,
                $book->price,
                $book->stock
            ]);
        }
    }

    private function renderLine(array $line): void
    {
        echo implode("\t", $line) . PHP_EOL;
    }
}
