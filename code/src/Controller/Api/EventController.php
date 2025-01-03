<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\Entity\Event;
use App\Repository\EventRepositoryInterface;
use App\Service\Entity\EventParam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    public function __construct(private readonly EventRepositoryInterface $eventRepository)
    {
    }

    #[Route('/api/events', methods: ["GET"])]
    public function getEventAction(): Response
    {
        $arEvents = $this->eventRepository->getAll();
        return $this->json($arEvents);
    }

    #[Route('/api/event', methods: ["POST"])]
    public function addEventAction(#[MapRequestPayload] Event $event): Response
    {
        $this->eventRepository->save($event);
        return $this->json("");
    }

    #[Route('/api/events', methods: ["DELETE"])]
    public function cleanEventsAction(): Response
    {
        $this->eventRepository->removeAll();
        return $this->json("");
    }

    /**
     * @param EventParam[] $params
     */
    #[Route('/api/event/relevant', methods: ["GET"])]
    public function getRelevantEventAction(#[MapRequestPayload(type: EventParam::class)] array $params): Response
    {
        $event = $this->eventRepository->getRelevant($params);
        return $this->json($event);
    }
}
