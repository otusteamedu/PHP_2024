<?php

/** @noinspection PhpMissingFieldTypeInspection */

declare(strict_types=1);

namespace app\application\form;

use app\base\factory\QueryFactory;
use app\base\form\BaseForm;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="AddTasksForm"
 * )
 */
final class CheckStatusForm extends BaseForm
{
    /**
     * @OA\Property(
     *     type="string",
     *     title="Id"
     * )
     */
    public $id;


    public function rules(): array
    {
        return [
            [['id'], 'required'],
            [['id'], 'string', 'min' => 36, 'max' => 36],
            ['id', 'validateId']
        ];
    }

    public function validateId($attribute): void
    {
        $exist = \Yii::createObject(QueryFactory::class)
            ->create()
            ->from('{{%tasks}}')
            ->andWhere([
                'id' => $this->id,
            ])->exists();

        if (!$exist) {
            $this->addError($attribute, 'Данной задачи не существует');
        }
    }
}
