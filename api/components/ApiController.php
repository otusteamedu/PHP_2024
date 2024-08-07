<?php

declare(strict_types=1);

namespace api\components;

use ReflectionMethod;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\web\Controller;

class ApiController extends Controller
{
    /**
     * @param Action $action
     * @param mixed $result
     * @throws InvalidConfigException
     */
    public function afterAction($action, $result): mixed
    {
        $result = $this->serializeData($result);
        return parent::afterAction($action, $result);
    }

    /**
     * Creates an action based on the given action ID.
     * The method first checks if the action ID has been declared in [[actions()]]. If so,
     * it will use the configuration declared there to create the action object.
     * If not, it will look for a controller method whose name is in the format of `actionXyz`
     * where `xyz` is the action ID. If found, an [[InlineAction]] representing that
     * method will be created and returned.
     * @param string $id the action ID
     * @return Action|ApiInlineAction|null the newly created action instance. Null if the ID doesn't resolve into any action.
     * @throws InvalidConfigException
     */
    public function createAction($id): Action|ApiInlineAction|null
    {
        if ($id === '') {
            $id = $this->defaultAction;
        }

        $actionMap = $this->actions();
        if (isset($actionMap[$id])) {
            return Yii::createObject($actionMap[$id], [$id, $this]);
        }

        if (preg_match('/^(?:[a-z0-9_]+-)*[a-z0-9_]+$/', $id)) {
            $methodName = 'action' . str_replace(' ', '', ucwords(str_replace('-', ' ', $id)));
            if (method_exists($this, $methodName)) {
                $method = new ReflectionMethod($this, $methodName);
                if ($method->isPublic() && $method->getName() === $methodName) {
                    return new ApiInlineAction($id, $this, $methodName);
                }
            }
        }

        return null;
    }

    /**
     * @param $data
     * @throws InvalidConfigException
     */
    protected function serializeData($data): mixed
    {
        return Yii::createObject(ApiSerializer::class, [$this->response])->serialize($data);
    }
}
