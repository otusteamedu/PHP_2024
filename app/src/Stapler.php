<?php
namespace Pavelsergeevich\Hw4;

use \InvalidArgumentException;
use \LengthException;

/**
 * Класс для работы со скобками
 * @note Степлер потому что скобочник:)
 */
class Stapler
{
    /**
     * Максимальная длина строки
     */
    public const MAX_STAPLES_LENGTH = 255;
    /**
     * Массив допустимых символов скобок в формате [{Открывающая} => {Закрывающая}, ...]
     */
    public const ACCEPTABLE_STAPLES = ['(' => ')', '{' => '}', '[' => ']', '<' => '>'];
    private string $staples;

    /**
     * @param string|null $staples Строка со скобками, можно установить позже с помощью метода setStaples()
     */
    public function __construct(?string $staples)
    {
        $this->setStaples($staples);
    }

    public function setStaples(?string $staples): self
    {
        if ($staples && (mb_strlen($staples) > self::MAX_STAPLES_LENGTH)) {
            throw new LengthException('Превышено допустимое количество символов в строке. Допустимое количество: ' . self::MAX_STAPLES_LENGTH);
        }

        $this->staples = $staples ? : '';
        return $this;
    }

    public function getStaples(): string
    {
        return $this->staples;
    }

    /**
     * Проверяет строку на валидность открывающих и закрывающих символов
     * @return array Пример: ['isValid' => true, 'message' => 'Строка полностью валидна']
     */
    public function isValid(): array
    {
        $arStaples = str_split($this->getStaples(), 1);

        //Строка содержащая стек открытых скобочек, пример: "({{([("
        $openedStapleStack = '';

        foreach ($arStaples as $key => $staple) {
            //Если открывающая скобка
            if (in_array($staple, array_keys(self::ACCEPTABLE_STAPLES))) {
                $openedStapleStack .= $staple;
            }
            //Если закрывающая скобка
            else if (in_array($staple, self::ACCEPTABLE_STAPLES)) {
                if (mb_strlen($openedStapleStack) === 0) {
                    return [
                        'isValid' => false,
                        'message' => "Обнаружен неподходящий символ: $staple [$key]. Отсутствует открывающий символ."
                    ];
                }

                $openedStapleForCurrent = array_search($staple, self::ACCEPTABLE_STAPLES);
                $lastStapleInOpenedStack = mb_substr($openedStapleStack, -1);
                if ($openedStapleForCurrent !== $lastStapleInOpenedStack) {
                    return [
                        'isValid' => false,
                        'message' => "Обнаружен неподходящий символ: $staple [$key]. Ожидался закрывающий символ для $lastStapleInOpenedStack"
                    ];
                }

                $openedStapleStack = mb_substr($openedStapleStack, 0, mb_strlen($openedStapleStack)-1);
            }
            //Если неуместный символ
            else {
                throw new InvalidArgumentException(
                    "Передан некорректный символ, допустимы только описанные в \Pavelsergeevich\Hw4\Stapler::ACCEPTABLE_STAPLES. Переданный символ: \"$staple\" [$key]"
                );
            }
        }

        if (mb_strlen($openedStapleStack) > 0) {
            return [
                'isValid' => false,
                'message' => "Имеются незакрытые символы. Оставшийся стек открытых символов: $openedStapleStack"
            ];
        } else {
            return [
                'isValid' => true,
                'message' => "Скобочная строка полностью валидна"
            ];
        }
    }

}