<?php

declare(strict_types=1);

namespace api\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex(): array
    {
        return [
            'status' => 'ok',
        ];
    }
}
