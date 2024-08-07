<?php

namespace api\modules\v1\controllers;

use api\attributes\ValidateFormAttribute;
use api\components\ApiController;
use app\application\command\add_tasks\Command;
use app\application\command\add_tasks\Handler;
use app\application\form\AddTasksForm;
use app\application\form\CheckStatusForm;
use Yii;
use yii\filters\VerbFilter;

class SendController extends ApiController
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    '*' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * @OA\Get  (
     *     tags={"send"},
     *     path="/v1/send/tasks",
     *     summary="Add tasks",
     *     @OA\Response(response="200", description="Success result"),
     *     @OA\Response(response="422", description="Error: Data Validation Failed.", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ErrorModel"))),
     *     @OA\Parameter(name="phone", required=true, in="query", @OA\Schema(type="string", default="73453322222"))
     * )
     */
    #[ValidateFormAttribute]
    public function actionTasks(AddTasksForm $form): array
    {
        $handler = Yii::createObject(Handler::class);

        return [
            'id' => $handler->handler(new Command(
                $form->phone
            ))
        ];
    }

    /**
     * @OA\Get  (
     *     tags={"send"},
     *     path="/v1/send/check-tasks",
     *     summary="Add tasks",
     *     @OA\Response(response="200", description="Success result"),
     *     @OA\Response(response="422", description="Error: Data Validation Failed.", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ErrorModel"))),
     *     @OA\Parameter(name="id", required=true, in="query", @OA\Schema(type="string"))
     * )
     */
    #[ValidateFormAttribute]
    public function actionCheckTasks(CheckStatusForm $form): array
    {
        $handler = Yii::createObject(\app\application\command\check_tasks\Handler::class);

        return $handler->handler(new \app\application\command\check_tasks\Command(
            $form->id
        ));
    }
}
