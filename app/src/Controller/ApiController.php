<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\TaskRequestDto;
use App\Entity\Task;
use App\Rabbitmq\Message\TaskMessage;
use App\Rabbitmq\Producer\TaskProducer;
use App\Repository\TaskRepository;
use App\Service\TaskService;
use App\Service\Validator;
use Cassandra\Exception\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1')]
class ApiController extends AbstractController
{
    private const LIMIT = 10;

    public function __construct(
        private readonly TaskService $taskService,
        private readonly TaskRepository $repository,
        private readonly TaskProducer $producer,
        private readonly Validator $validator,
    ) {
    }

    #[Route('/tasks', name: 'create_task', methods: ['POST'])]
    public function createTask(#[MapRequestPayload] TaskRequestDto $dto): JsonResponse
    {
        try {
            $task = $this->taskService->createTask($dto);
            $this->producer->publish(TaskMessage::creteFromTask($task));

            return new JsonResponse([
                'message' => 'Task request has been accepted',
                'id' => $task->getId(),
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    #[Route('/tasks', name: 'get_tasks', methods: ['GET'])]
    public function getTasks(Request $request): JsonResponse
    {
        try {
            $offset = $request->query->getInt('offset');
            $limit = $request->query->getInt('limit', self::LIMIT);

            return new JsonResponse([
                'offset' => $offset,
                'limit' => $limit,
                'count' => $this->repository->count(),
                'tasks' => $this->repository->findBy([], limit: $limit, offset: $offset),
            ]);
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    #[Route('/tasks/{id}', name: 'get_task', methods: ['GET'])]
    public function getTask(Task $task): JsonResponse
    {
        try {
            return new JsonResponse([
                'task' => $task,
            ]);
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    #[Route('/tasks/{id}', name: 'delete_task', methods: ['DELETE'])]
    public function deleteTask(string $id): JsonResponse
    {
        try {
            $task = $this->repository->find((int) $id);

            if ($task instanceof Task) {
                $this->repository->delete($task);
            }

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    #[Route('/tasks/{id}', name: 'put_task', methods: ['PUT'])]
    public function putTask(Task $task, Request $request): JsonResponse
    {
        try {
            $dto = TaskRequestDto::createFromParameters($this->convertRequestBodyToArray($request));
            $errors = $this->validator->validate($dto);

            if (0 < count($errors)) {
                return new JsonResponse([ 'errors' => $errors ], Response::HTTP_BAD_REQUEST);
            }

            $task = $this->taskService->putTask($task, $dto);

            return new JsonResponse([
                'task' => $task,
            ]);
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    #[Route('/tasks/{id}', name: 'patch_task', methods: ['PATCH'])]
    public function patchTask(Task $task, Request $request): JsonResponse
    {
        try {
            $requestData = $this->convertRequestBodyToArray($request);
            $parameters = $this->extractValidParameters($requestData);

            if (0 === count($parameters)) {
                return new JsonResponse([ 'errors' => 'No valid data provided.' ], Response::HTTP_BAD_REQUEST);
            }

            $task = $this->taskService->patchTask($task, $parameters);
            $errors = $this->validator->validate($task);

            if (0 < count($errors)) {
                return new JsonResponse([ 'errors' => $errors ], Response::HTTP_BAD_REQUEST);
            }

            $this->repository->flush();

            return new JsonResponse([
                'task' => $task,
            ]);
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    private function errorResponse(\Throwable $e): JsonResponse
    {
        if ($e instanceof \JsonException) {
            return new JsonResponse([
                'error' => 'Not valid JSON',
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'error' => $e->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @throws \JsonException
     */
    private function convertRequestBodyToArray(Request $request): array
    {
        return json_decode($request->getContent(), true, flags: JSON_THROW_ON_ERROR);
    }

    private function extractValidParameters(array $requestData): array
    {
        $parameters = [];

        foreach ($requestData as $key => $value) {
            if (in_array($key, Task::REQUEST_FIELDS, true)) {
                $parameters[$key] = $value;
            }
        }

        return $parameters;
    }
}
