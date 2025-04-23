<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Mapper;

use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\CaseNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\GeneralNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\JudgeFio;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\RegisterDate;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Title;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Uid;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Url;
use AnatolyShilyaev\Backend\Domain\CourtCaseWithStatus\Entity\CourtCaseWithStatus;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\ErrorType;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\Status;
use AnatolyShilyaev\Backend\Domain\Event\ValueObject\CourtCaseID;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtCaseWithStatusFactory;
use DateTimeImmutable;
use PDO;

class CourtCaseWithStatusMapper
{
    private PDO $pdo;
    private CourtCaseWithStatusFactory $factory;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->factory = new CourtCaseWithStatusFactory();
    }

    public function getAll(): iterable
    {
        $stmt = $this->pdo->prepare("SELECT 
                                        court_cases.*, 
                                        court_parse_statuses.status, 
                                        court_parse_statuses.error_type
                                    FROM 
                                        court_cases
                                    LEFT JOIN 
                                        court_parse_statuses ON court_cases.id = court_parse_statuses.court_case_id
                                    WHERE
                                        court_parse_statuses.status IS NOT NULL
                                    ");
        $stmt->execute();
        $courtCasesWithStatuses = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courtCasesWithStatuses[] =  $this->hydrate($data);
        }

        return $courtCasesWithStatuses;
    }

    private function hydrate(array $data): CourtCaseWithStatus
    {
        $id = $data['id'];
        $title = new Title($data['title']);
        $generalNumber = new GeneralNumber($data['general_number']);
        $uid = new Uid($data['uid']);
        $caseNumber = new CaseNumber($data['case_number']);
        $url = new Url($data['url']);
        $judgeFio = new JudgeFio($data['judge_fio']);
        $registerDate = isset($data['register_date'])
            ? new RegisterDate(new \DateTimeImmutable($data['register_date']))
            : new RegisterDate(null);
        $status = new Status($data['status']);
        $errorType = new ErrorType($data['error_type']);
        $events = (new EventMapper($this->pdo))->getByID(new CourtCaseID($id));

        return $this->factory->create(
            $title,
            $generalNumber,
            $uid,
            $caseNumber,
            $url,
            $judgeFio,
            $registerDate,
            $status,
            $errorType,
            $events,
            [],
            $id,
        );
    }
}
