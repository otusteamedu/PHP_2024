<?php

declare(strict_types=1);

namespace api\components;

use api\attributes\ValidateFormAttribute;
use api\entity\ErrorResultEntity;
use app\base\form\BaseForm;
use ReflectionAttribute;
use ReflectionException;
use ReflectionMethod;
use RuntimeException;
use Yii;
use yii\base\InlineAction;
use yii\helpers\ArrayHelper;

class ApiInlineAction extends InlineAction
{
    /**
     * Runs this action with the specified parameters.
     * This method is mainly invoked by the controller.
     * @param array $params action parameters
     * @throws ReflectionException
     * @throws \yii\console\Exception
     * @throws \yii\web\BadRequestHttpException
     * @return mixed the result of the action
     */
    public function runWithParams($params)
    {
        $args = $this->controller->bindActionParams($this, $params);
        Yii::debug('Running action: ' . \get_class($this->controller) . '::' . $this->actionMethod . '()', __METHOD__);
        if (Yii::$app->requestedParams === null) {
            Yii::$app->requestedParams = $args;
        }

        $method = new ReflectionMethod($this->controller, $this->actionMethod);
        $attributes = $method->getAttributes(ValidateFormAttribute::class);

        if (\count($attributes) > 0) {
            $attribute = current($attributes);
            /** @var ReflectionAttribute $attribute */
            /** @var ValidateFormAttribute $validateFormAttribute */
            $validateFormAttribute =  $attribute->newInstance();
            $numParams = $validateFormAttribute->getFormNumArgs();
            $form = ArrayHelper::getValue($args, $numParams);

            if (empty($form) || !($form instanceof BaseForm)) {
                throw new RuntimeException('Not found ValidateFormAttribute');
            }

            if ($form->hasErrors()) {
                return new ErrorResultEntity($form);
            }
        }

        return \call_user_func_array([$this->controller, $this->actionMethod], $args);
    }
}
