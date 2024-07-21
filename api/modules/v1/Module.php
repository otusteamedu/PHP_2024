<?php

declare(strict_types=1);

namespace api\modules\v1;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init(): void
    {
        parent::init();
    }
}
