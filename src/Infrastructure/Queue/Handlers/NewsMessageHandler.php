<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\Handlers;

use App\Domain\Repository\NewsInterface;
use App\Infrastructure\Queue\Messages\NewsMessage;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class NewsMessageHandler
{
    public function __construct(
        private readonly NewsInterface $newsRepository,
        private readonly EntityManagerInterface $em,
    ) {} // phpcs:ignore

    /**
     * @throws Throwable
     * @throws Exception
     */
    public function __invoke(NewsMessage $message): void
    {
        $news = $this->newsRepository->findByParams(['id' => $message->getNewsId()]);

        if (empty($news)) {
            return;
        }

        $foundNews = array_pop($news);
        $this->em->getConnection()->beginTransaction();

        try {
            $foundNews->setStatus('processed');
            $this->newsRepository->save($foundNews);

            // TODO: do something

            $foundNews->setStatus('success');
            $this->newsRepository->save($foundNews);
            $this->em->getConnection()->commit();
        } catch (Throwable $e) {
            $this->em->getConnection()->rollback();
            $foundNews->setStatus('failed');
            $this->newsRepository->save($foundNews);
            throw $e;
        }
    }
}
