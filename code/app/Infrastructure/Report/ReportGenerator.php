<?php

declare(strict_types=1);

namespace App\Infrastructure\Report;

use App\Application\Report\GeneratorInterface;
use App\Application\Report\ReportItemCollection;
use Illuminate\Support\Facades\Storage;

class ReportGenerator implements GeneratorInterface
{
    /**
     * @inheritDoc
     */
    public function generate(ReportItemCollection $items): string
    {
        $content = view('report', ['itemList' => $items]);
        $fileName = uniqid() . '.html';
        Storage::put('public/' . $fileName, $content);

        return asset('storage/' . $fileName);
    }
}
