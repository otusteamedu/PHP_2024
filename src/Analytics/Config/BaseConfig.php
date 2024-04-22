<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Config;

use ReflectionProperty;
use ReflectionException;
use LogicException;

abstract class BaseConfig
{
    protected array $config;

    /**
     * @param $filename
     * @throws ConfigFileReadException
     */
    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            throw new ConfigFileReadException("Файл конфигурации $filename не найден!");
        }

        $this->config = parse_ini_file($filename, true);
        if ($this->config === false) {
            throw new ConfigFileReadException('Некорректный файл конфигурации!');
        }
    }

    /**
     * @param string $sectionName
     * @param array $fields
     * @return void
     * @throws ConfigValidationException
     */
    protected function readSection(string $sectionName, array $fields): void
    {
        if (!is_array($this->config[$sectionName])) {
            throw new ConfigValidationException("В конфигурации должна быть секция $sectionName!");
        }

        $section = $this->config[$sectionName];
        foreach ($fields as $key => $value) {
            $isKeyInteger = filter_var($key, FILTER_VALIDATE_INT) !== false;
            if ($isKeyInteger) {
                $configFieldName = $value;
                $objectFieldName = $this->convertSnakeCaseStringToCamelCaseString($value);
            } else {
                $configFieldName = $key;
                $objectFieldName = $value;
            }

            if (!array_key_exists($configFieldName, $section) || $section[$configFieldName] === '') {
                throw new ConfigValidationException($this->getFieldIsEmptyErrorMessage($configFieldName, $sectionName));
            }

            $this->setFiledValue($objectFieldName, $section[$configFieldName]);
        }
    }

    private function getFieldIsEmptyErrorMessage(string $fieldName, string $sectionName): string
    {
        return "В конфигурации в секции $sectionName должно быть поле $fieldName!";
    }

    private function convertSnakeCaseStringToCamelCaseString(string $s): string
    {
        return lcfirst(str_replace('_', '', ucwords($s, '_')));
    }

    /**
     * @param string $fieldName
     * @param string $fieldValue
     * @return void
     * @throws ConfigValidationException
     */
    private function setFiledValue(string $fieldName, string $fieldValue): void
    {
        try {
            $reflectionProperty = new ReflectionProperty(static::class, $fieldName);
            $filedType = $reflectionProperty->getType()->getName();
            if (!settype($fieldValue, $filedType)) {
                throw new ConfigValidationException("Тип поля $fieldName не соответствует значению из файла!");
            }

            $reflectionProperty->setValue($this, $fieldValue);
        } catch (ReflectionException $e) {
            throw new LogicException($e->getMessage());
        }
    }
}
