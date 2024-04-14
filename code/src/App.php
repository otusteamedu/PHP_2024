<?php

namespace Irayu\Hw6;

use Irayu\Hw6;

class App
{
    private mixed $output;
    private bool $isHTMLFormat = false;


    protected function initConfigs(?string $configFile = null): static
    {
        $logFile = null;
        if ($configFile && file_exists($configFile)) {
            $options = parse_ini_file($configFile);
            if (isset($options['log_file_path'])) {
                $logFile = $options['log_file_path'];
            }
        }
        if ($logFile) {
            $this->output = fopen($logFile, 'a');
        } else if (defined('STDIN')) {
            $this->output = fopen('php://stdout', 'w');
        } else {
            $this->output = fopen('php://output', 'w');
            $this->isHTMLFormat = true;
        }

        return $this;
    }

    protected function validate(array $emails): array
    {
        $logData = [];
        $validator = new Hw6\EmailValidator();
        foreach ($emails as $email) {
            $answer = [];
            $result = $validator->check($email);
            if ($result->isSucceed()) {
                $answer[] = 'OK';
            } else {
                foreach ($result->getErrors() as $error) {
                    $answer[] = $error->getMessage();
                }
            }
            $logData[$email] = $answer;
        }

        return $logData;
    }

    private function outputHTML(array $logData): string
    {
        $output = '<table>';
        foreach ($logData as $email => $answer) {
            $output .= '<tr><td>' . $email . '</td><td>' . implode(', ', $answer) . '</td></tr>';
        }
        $output .= '</table>';

        return $output;
    }
    private function outputText(array $logData): string
    {
        $output = '';
        foreach ($logData as $email => $answer) {
            $output .= $email . ': ' . implode(', ', $answer) . PHP_EOL;
        }

        return $output;
    }

    public function run(array $emails): void
    {
        $this->initConfigs();
        $answer = $this->validate($emails);

        fwrite($this->output, $this->isHTMLFormat ? $this->outputHTML($answer) : $this->outputText($answer));
    }
}
