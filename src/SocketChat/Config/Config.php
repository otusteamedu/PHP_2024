<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Config;

use Exception;

class Config extends BaseConfig
{
    private string $socketPath;
    private int $messageMaxLength;
    private string $stopWord;

    public function __construct($filename)
    {
        parent::__construct($filename);
        $this->validate();
    }

    public function getSocketPath(): string
    {
        return $this->socketPath;
    }

    public function getMessageMaxLength(): int
    {
        return $this->messageMaxLength;
    }

    public function getStopWord(): string
    {
        return $this->stopWord;
    }

    /**
     * @return void
     * @throws Exception
     */
    private function validate(): void
    {
        $sectionKey = 'socket';
        if (!is_array($this->config[$sectionKey])) {
            throw new Exception("В конфигурации должна быть секция $sectionKey!");
        }

        $socketConfigSection = $this->config[$sectionKey];
        if (empty($socketConfigSection['socket_path'])) {
            throw new Exception($this->getFieldIsEmptyErrorMessage('socket_path', $sectionKey));
        }

        if (empty($socketConfigSection['message_max_length'])) {
            throw new Exception($this->getFieldIsEmptyErrorMessage('message_max_length', $sectionKey));
        }

        if (empty($socketConfigSection['stop_word'])) {
            throw new Exception($this->getFieldIsEmptyErrorMessage('stop_word', $sectionKey));
        }

        $this->socketPath = $socketConfigSection['socket_path'];
        $this->messageMaxLength = (int)$socketConfigSection['message_max_length'];
        $this->stopWord = $socketConfigSection['stop_word'];
    }

    private function getFieldIsEmptyErrorMessage(string $fieldName, string $sectionKey): string
    {
        return "В конфигурации в секции $sectionKey должно быть поле $fieldName!";
    }
}
