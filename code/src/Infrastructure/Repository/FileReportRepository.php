<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Repository;

use Irayu\Hw15\Domain;
use Irayu\Hw15\Domain\Entity\Report;

class FileReportRepository implements Domain\Repository\ReportRepositoryInterface
{
    private $filename;
    private $lastId = 0;

    public function __construct($filename)
    {
        $this->filename = $filename;
        if (!file_exists($this->filename)) {
            $f = fopen($this->filename, 'w');
            fclose($f);
        }
    }

    public function save(Report $report): void
    {
        $data = $this->load();
        $data['lastId'] = ++$this->lastId;
        $data['items'][$this->lastId] = [
            'hash' => $report->getHash(),
            'newsIds' => $report->getNewsItemIds()
        ];

        file_put_contents($this->filename, json_encode($data));

        (new \ReflectionProperty(Domain\Entity\Report::class, 'id'))
            ->setValue($report, $this->lastId)
        ;
    }

    private function load()
    {
        $data = file_get_contents($this->filename);
        $data = json_decode($data, true);
        if (!(is_array($data) && array_key_exists('lastId', $data) && array_key_exists('items', $data))) {
            $data = ['lastId' => 0, 'items' => []];
        }
        $this->lastId = (int)$data['lastId'];

        return $data;
    }

    public function findById(int $id): ?Domain\Entity\Report
    {
        $data = $this->load();
        if (array_key_exists($id, $data['items'])) {
            return $this->createReport($data['items'][$id], $id);
        }

        return null;
    }

    private function createReport($item, $id): Domain\Entity\Report
    {
        $report = new Domain\Entity\Report(
            $item['newsIds']
        );

        (new \ReflectionProperty($report::class, 'id'))
           ->setValue($report, $id)
        ;
        (new \ReflectionProperty($report::class, 'hash'))
            ->setValue($report, $item['hash'])
        ;

        return $report;
    }
}
