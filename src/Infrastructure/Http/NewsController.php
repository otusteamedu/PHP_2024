<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\GetNews;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use App\Application\UseCase\CreateNews;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Request\GetNewsRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(title="News API", version="1.0")
 * )
 */
class NewsController extends AbstractFOSRestController
{
    public function __construct(
        private CreateNews $createNewsUseCase,
        private GetNews $getNewsUseCase
    ) {} // phpcs:ignore

    /**
     * @OA\Post(
     *      path="/api/v1/news/create",
     *      summary="Create news",
     *      operationId="createNews",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="url",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string"
     *                  ),
     *                  example={"url": "https://news.mail.ru/politics/61452546", "title": "test"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *               @OA\Property(property="id", type="int", example="1"),
     *          )
     *      )
     *  )
     * @Rest\Post("/api/v1/news/create")
     * @ParamConverter("request", converter="fos_rest.request_body")
     * @param CreateNewsRequest $request
     * @return Response
     */
    public function createAction(CreateNewsRequest $request): Response
    {
        try {
            $response = ($this->createNewsUseCase)($request);
            $view = $this->view($response, 201);
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            $view = $this->view($errorResponse, 400);
        }

        return $this->handleView($view);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/news/getStatus/{id}",
     *      summary="Get news status",
     *      @OA\Parameter(
     *          description="Parameter with mutliple examples",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="string"),
     *          @OA\Examples(example="int", value="1", summary="An int value."),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="News status",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *         )
     *      ),
     *  )
     * @Rest\Get("/api/v1/news/getStatus/{id}")
     * @param int $id
     * @return Response
     */
    public function getNewsAction(int $id): Response
    {
        try {
            $response = ($this->getNewsUseCase)(new GetNewsRequest($id));
            $view = $this->view($response, 201);
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            $view = $this->view($errorResponse, 400);
        }

        return $this->handleView($view);
    }
}
