<?php

/** @noinspection PhpMissingFieldTypeInspection */

declare(strict_types=1);

namespace app\application\form;

use app\base\form\BaseForm;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="AddTasksForm"
 * )
 */
final class AddTasksForm extends BaseForm
{
    /**
     * @OA\Property(
     *     type="string",
     *     default="73453322222",
     *     title="Мобильный номер телефона"
     * )
     */
    public $phone;


    public function rules(): array
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'match', 'pattern' => '/^7(3|4|5|6|8|9)\d{9}$/'],
        ];
    }
}
