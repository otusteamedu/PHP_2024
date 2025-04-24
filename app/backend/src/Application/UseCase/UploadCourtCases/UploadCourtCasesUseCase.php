<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\UploadCourtCases;

use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\CaseNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\GeneralNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\JudgeFio;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\RegisterDate;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Title;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Uid;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Url;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtCaseFactory;
use AnatolyShilyaev\Backend\Infrastructure\Repository\CourtCaseRepository;

class UploadCourtCasesUseCase
{
    public function __construct(
        private readonly CourtCaseFactory $factory,
        private readonly CourtCaseRepository $repository,
    ) {
        // Empty constructor
    }

    public function __invoke(array $uploadCourtCasesRequest): void
    {
        $courtCases = [];
        foreach ($uploadCourtCasesRequest as $request) {
            //Prepare ValueObjects
            $title = new Title("");
            $generalNumber = new GeneralNumber($request->generalNumber);
            $uid = new Uid("");
            $caseNumber = new CaseNumber("");
            $url = new Url($request->url);
            $judgeFio = new JudgeFio("");
            $registerDate = new RegisterDate(null);

            // Add CourtCase
            $courtCases[] = $this->factory->create($title, $generalNumber, $uid, $caseNumber, $url, $judgeFio, $registerDate, [], [], null);
        }


        //Save news to DB
        $this->repository->upload($courtCases);
    }
}
