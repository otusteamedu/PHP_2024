<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Repository;

use AnatolyShilyaev\Backend\Domain\CourtCase\Entity\CourtCase;
use AnatolyShilyaev\Backend\Domain\CourtCase\Repository\CourtCaseRepositoryInterface;
use AnatolyShilyaev\Backend\Infrastructure\Config\Connection;
use AnatolyShilyaev\Backend\Infrastructure\Mapper\CourtCaseMapper;

class CourtCaseRepository implements CourtCaseRepositoryInterface
{
    private CourtCaseMapper $mapper;

    public function __construct()
    {
        $pdo = Connection::get()->connect();
        $this->mapper = new CourtCaseMapper($pdo);
    }

    /**
     * @param CourtCase $news
     * @return void
     */
    public function save(CourtCase $courtCase): void
    {
        $courtCaseId = $this->mapper->save($courtCase);
        $reflectionProperty = new \ReflectionProperty(CourtCase::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($courtCase, $courtCaseId);
    }

    public function update(CourtCase $courtCase): void
    {
        $courtCaseId = $this->mapper->update($courtCase);
    }

    public function upload(array $courtCases): void
    {
        $this->mapper->upload($courtCases);
    }

    /**
     * @return CourtCase[]
     */
    public function getAll(): iterable
    {
        $allCourtCases = $this->mapper->getAll();
        return $allCourtCases;
    }

    public function getTotalCount(): int
    {
        $totalCount = $this->mapper->getTotalCount();
        return $totalCount;
    }

    // /**
    //  * @param GetReportNewsRequest $request
    //  * @return News[]
    //  */
    // public function findByIds(GetReportNewsRequest $request): iterable
    // {
    //     $news = $this->mapper->findByIds($request);
    //     return $news;
    // }
}
