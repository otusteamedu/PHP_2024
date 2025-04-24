<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Mapper;

use AnatolyShilyaev\Backend\Domain\CourtCase\Entity\CourtCase;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\CaseNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\GeneralNumber;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\JudgeFio;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\RegisterDate;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Title;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Uid;
use AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject\Url;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtCaseFactory;
use DateTimeImmutable;
use PDO;

class CourtCaseMapper
{
    private PDO $pdo;
    private CourtCaseFactory $factory;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->factory = new CourtCaseFactory();
    }

    public function save(CourtCase $courtCase): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO court_cases (url, general_number) 
            VALUES (:url, :general_number)"
        );

        $stmt->execute([
            'url' => $courtCase->getUrl()->getValue(),
            'general_number' => $courtCase->getGeneralNumber()->getValue(),
        ]);

        $id = (int) $this->pdo->lastInsertId();

        return $id;
    }

    public function update(CourtCase $courtCase): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE court_cases 
             SET title = :title, uid = :uid, case_number = :case_number, judge_fio = :judge_fio, register_date = :register_date 
             WHERE id = :id"
        );

        $stmt->execute([
            'id' => $courtCase->getId(),
            'title' => $courtCase->getTitle()->getValue(),
            'uid' => $courtCase->getUid()->getValue(),
            'case_number' => $courtCase->getCaseNumber()->getValue(),
            'judge_fio' => $courtCase->getJudgeFio()->getValue(),
            'register_date' => $courtCase->getRegisterDate()->getValue()
                ? $courtCase->getRegisterDate()->getValue()->format('Y-m-d')
                : null,
        ]);
    }

    public function upload(array $courtCases): void
    {
        foreach ($courtCases as $courtCase) {
            $url = $courtCase->getUrl()->getValue();
            $generalNumber = $courtCase->getGeneralNumber()->getValue();

            if (empty($url)) {
                continue; // пропускаем, если нет url
            }

            // Вставка с возвратом UUID
            $stmt = $this->pdo->prepare(
                "INSERT INTO court_cases (url, general_number) 
                VALUES (:url, :general_number)
                RETURNING id"
            );

            $stmt->execute([
                'url' => $url,
                'general_number' => $generalNumber,
            ]);

            $id = $stmt->fetchColumn();

            if ($id) {
                $stmtStatus = $this->pdo->prepare(
                    "INSERT INTO court_parse_statuses (court_case_id) 
                    VALUES (:court_case_id)"
                );

                $stmtStatus->execute([
                    'court_case_id' => $id,
                ]);
            }
        }
    }

    public function getAll(): iterable
    {
        // $stmt = $this->pdo->prepare("SELECT * FROM court_cases");
        $stmt = $this->pdo->prepare("SELECT 
                                        court_cases.*, 
                                        court_parse_statuses.status, 
                                        court_parse_statuses.error_type
                                    FROM 
                                        court_cases
                                    LEFT JOIN 
                                        court_parse_statuses ON court_cases.id = court_parse_statuses.court_case_id
                                    WHERE
                                        court_parse_statuses.status IS NULL
                                    ");
        $stmt->execute();
        $courtCases = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courtCases[] =  $this->hydrate($data);
        }

        return $courtCases;
    }

    public function getTotalCount(): int
    {
        // $stmt = $this->pdo->prepare("SELECT * FROM court_cases");
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM court_cases");
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count;
    }

    // public function findByIds(GetReportNewsRequest $request): iterable
    // {
    //     if (empty($request->ids)) {
    //         return [];
    //     }

    //     $placeholders = implode(',', array_fill(0, count($request->ids), '?'));
    //     $stmt = $this->pdo->prepare("SELECT * FROM news WHERE id IN ($placeholders)");
    //     $stmt->execute($request->ids);

    //     while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //         $news[] = $this->hydrateNews($data);
    //     }

    //     return $news;
    // }

    private function hydrate(array $data): CourtCase
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

        return $this->factory->create(
            $title,
            $generalNumber,
            $uid,
            $caseNumber,
            $url,
            $judgeFio,
            $registerDate,
            [],
            [],
            $id,
        );
    }
}
