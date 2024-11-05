<?php

declare(strict_types=1);

namespace Irayu\Hw13\UI\View;

use PHPYurta\CLI\CLITable;
use Irayu\Hw13\Domain;

class CompetitionView
{
    /**
     * @param Domain\Competition[] $competitions
     * @return void
     */
    public function __construct(
        protected array $competitions
    ) {
    }

    public function render(): string
    {
        $table = new CLITable();
        $headers = ['Name', 'Start', 'Finish', 'Location', 'Routes'];
        $table->setHeaders($headers);
        foreach ($this->competitions as $competition) {
            $row = [
                $competition->name,
                $competition->start->format('Y-m-d H:i:s'),
                $competition->finish->format('Y-m-d H:i:s'),
                $competition->location,
                count($competition->getBoulderProblems()),
            ];
            $table->addRow($row);
        }

        return $table->getTableOutput();
    }
}
