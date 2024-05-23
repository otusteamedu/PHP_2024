<?php

declare(strict_types=1);

namespace App\Infrastructure\Exporter;

use App\Domain\Exporter\ExporterInterface;
use App\Domain\News\News;
use TCPDF;

class PDFExporter extends BaseExporter
{
    public function exportNews(News $news): string
    {
        $pdf = new TCPDF();
        $pdf->setTitle($news->getTitle());
        $pdf->setAuthor($news->getAuthor()->getUsername());

        $pdf->setFontSubsetting(true);

        $pdf->setFont('freeserif', '', 12);
        
        $pdf->AddPage();

        // set color for text
        $pdf->setTextColor(0, 0, 0);
        $pdf->Write(5, $news->getBody(), '', 0, '', false, 0, false, false, 0);
        return $pdf->Output('_', 'S');
    }
}