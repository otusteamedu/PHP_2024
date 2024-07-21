<?php

declare(strict_types=1);
/**
 * @see http://www.yiiframework.com/
 * @license http://www.yiiframework.com/license/
 */

namespace console\components;

use Exception;
use Throwable;
use yii\helpers\Console;
use yii\helpers\VarDumper;
use yii\log\Logger;
use yii\log\Target;

/**
 * ConsoleTarget writes log to console (useful for debugging console applications).
 *
 * @author pahanini <pahanini@gmail.com>
 */
class FileTarget extends Target
{
    /**
     * @var bool If true context message will be added to the end of output
     */
    public $enableContextMassage = false;

    public $displayCategory = false;

    public $displayDate = true;

    public $dateFormat = 'Y-m-d H:i:s';

    public $padSize = 30;

    /**
     * @var array color scheme for message labels
     */
    public $color = [
        'error' => Console::BG_RED,
    ];

    public function export(): void
    {
        foreach ($this->messages as $message) {
            if ($message[1] === Logger::LEVEL_ERROR) {
                Console::error($this->formatMessage($message));
            } else {
                Console::output(mb_substr($this->formatMessage($message), 0, 10_000));
            }
        }
    }

    /**
     * @param array $message
     * 0 - massage
     * 1 - level
     * 2 - category
     * 3 - timestamp
     * 4 - ???
     *
     * @return string
     */
    public function formatMessage($message)
    {
        $label = $this->generateLabel($message);
        $text = $this->generateText($message);

        return str_pad($label, $this->padSize, ' ') . ' ' . $text;
    }

    /**
     * @return string
     */
    protected function getContextMessage()
    {
        return $this->enableContextMassage ? parent::getContextMessage() : '';
    }

    /**
     * @param mixed $message
     * @return string
     */
    private function generateLabel($message)
    {
        $label = '';

        // Add date to log
        if (true === $this->displayDate) {
            $label .= '[' . date($this->dateFormat, (int)$message[3]) . ']';
        }

        // Add category to label
        if (true === $this->displayCategory) {
            $label .= '[' . $message[2] . ']';
        }
        $level = Logger::getLevelName($message[1]);

        $tmpLevel = "[{$level}]";

        if (Console::streamSupportsAnsiColors(STDOUT)) {
            if (isset($this->color[$level])) {
                $tmpLevel = Console::ansiFormat($tmpLevel, [$this->color[$level]]);
            } else {
                $tmpLevel = Console::ansiFormat($tmpLevel, [Console::BOLD]);
            }
        }
        $label .= $tmpLevel;

        return $label;
    }

    /**
     * @param mixed $message
     * @return string
     */
    private function generateText($message)
    {
        $text = $message[0];
        if (!\is_string($text)) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure
            if ($text instanceof Throwable || $text instanceof Exception) {
                $text = (string)$text;
            } else {
                $text = VarDumper::export($text);
            }
        }

        return $text;
    }
}
