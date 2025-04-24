<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Mapper;

use AnatolyShilyaev\Backend\Domain\CourtParseStatus\Entity\CourtParseStatus;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\CourtCaseID;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\ErrorType;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\Status;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtParseStatusFactory;
use PDO;

class CourtParseStatusMapper
{
    private PDO $pdo;
    private CourtParseStatusFactory $factory;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->factory = new CourtParseStatusFactory();
    }

    public function update(CourtParseStatus $courtParseStatus): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE court_parse_statuses 
             SET status = :status, error_type = :error_type
             WHERE court_case_id = :court_case_id"
        );

        $stmt->execute([
            'court_case_id' => $courtParseStatus->getCourtCaseID()->getValue(),
            'status' => $courtParseStatus->getStatus()->getValue(),
            'error_type' => $courtParseStatus->getErrorType()->getValue(),
        ]);
    }

    public function getAll(): iterable
    {
        $stmt = $this->pdo->prepare("SELECT * FROM court_parse_statuses");
        $stmt->execute();
        $courtParseStatuses = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courtParseStatuses[] =  $this->hydrate($data);
        }

        return $courtParseStatuses;
    }

    private function hydrate(array $data): CourtParseStatus
    {
        $id = $data['id'];
        $courtCaseID = new CourtCaseID($data['court_case_id']);
        $status = new Status($data['status']);
        $errorType = new ErrorType($data['error_type']);

        return $this->factory->create(
            $courtCaseID,
            $status,
            $errorType,
            $id,
        );
    }
}
