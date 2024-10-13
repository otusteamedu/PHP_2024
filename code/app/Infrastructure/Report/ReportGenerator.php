<?php

declare(strict_types=1);

namespace App\Infrastructure\Report;

use App\Application\Report\GeneratorInterface;
use Illuminate\Support\Facades\Storage;

class ReportGenerator implements GeneratorInterface
{

    /**
     * @inheritDoc
     */
    public function generate(array $news): string
    {
        $content = view('report', ['newsList' => $news]);
        $fileName = uniqid() . '.html';
        Storage::put('public/' . $fileName, $content);

        return asset('storage/' . $fileName);
    }
}
