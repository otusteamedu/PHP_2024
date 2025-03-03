<?php

namespace App\Infrastructure\Repositories;


use App\Domain\Factory\RequestFactoryInterface;
use App\Domain\Repository\RequestRepositoryInterface;
use App\Infrastructure\Entity\StatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Infrastructure\Entity\Request as DbRecord;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Entity\Request;

class RequestOrmRepository extends ServiceEntityRepository implements RequestRepositoryInterface
{
    public function __construct(ManagerRegistry $registry , private readonly RequestFactoryInterface $factory)
    {
        parent::__construct($registry, DbRecord::class);
    }

    public function save(Request $request): void
    {
        $dbRecord = new DbRecord();
        $dbRecord->setRequesterName($request->getRequesterName()->getValue());
        $dbRecord->setRequesterEmail($request->getRequesterEmail()->getValue());
        $dbRecord->setStatus(StatusEnum::tryFrom($request->getStatus()->getValue()));
        $em = $this->getEntityManager();
        $em->persist($dbRecord);
        $em->flush();
        $reflectionProperty = new \ReflectionProperty(Request::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($request, $dbRecord->getId());
    }

    public function findById(int $id): ?Request
    {
        $item = $this->find($id);
        if (!$item) {
            return null;
        }
        /**
         * @var DbRecord $item
         */
        $request = $this->factory->create(
            $item->getRequesterName(),
            $item->getRequesterEmail(),
            $item->getStatus()->value
        );
        $reflectionProperty = new \ReflectionProperty(Request::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($request, $item->getId());
        return $request;
    }

    /**
     * @param int $id
     * @param Request $request
     * @return void
     */
    public function update(int $id, Request $request): void
    {
        $dbRecord = $this->find($id);
        $dbRecord->setRequesterName($request->getRequesterName()->getValue());
        $dbRecord->setRequesterEmail($request->getRequesterEmail()->getValue());
        $dbRecord->setStatus(StatusEnum::tryFrom($request->getStatus()->getValue()));
        $em = $this->getEntityManager();
        $em->flush();
    }
}
