<?php

declare(strict_types=1);

namespace Services;

use Exception;

class Email
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        if (! file_exists($filePath)) {
            throw new Exception("File not found: {$filePath}");
        }
        $this->filePath = $filePath;
    }

    public function getEmails(): array
    {
        return array_filter(array_map('trim', file($this->filePath)));
    }

    public function isValid(): array
    {
        $result = [];
        $emailList = $this->getEmails();

        foreach ($emailList as $email) {
            $isEmailRegexp = (is_string($email)) ? $this->checkRegexp($email) : false;
            $isEmailMX = (is_string($email)) ? $this->checkMX($email) : false;
            $result[$email] = [
                'isEmailRegexp' => $isEmailRegexp,
                'isEmailMX' => $isEmailMX
            ];
        }

        return $result;
    }

    private function checkRegexp(string $email): bool
    {
        return (preg_match("~([a-zA-Z0-9!#$%&'*+-/=?^_`{|}])@([a-zA-Z0-9-]).([a-zA-Z0-9]{2,4})~", $email)) ? true : false;
    }

    private function checkMX(string $email): bool
    {
        $emailArray = explode('@', $email);
        $hostname = end($emailArray);

        return getmxrr($hostname, $mxhosts);
    }

    public function getDebugResult(): void
    {
        $validResult = $this->isValid();

        echo '<pre>';
        var_export($validResult);
        echo '</pre>';
    }

    public function getReadableResult(): string
    {
        $validResult = $this->isValid();

        $html = $this->renderTable($validResult);

        return "
            <html>
                <head>
                    <title>Readable Result</title>
                </head>
                <body>
                    <h1>Result</h1>
                    {$html}
                </body>
            </html>";
    }

    private function renderTable(array $result): string
    {
        $headers = array_keys(reset($result));

        $headerTable = $this->getHeaderTable($headers);
        $bodyTable = $this->getBodyTable($headers, $result);

        $html = "
            <table border='1' cellpadding='5' cellspacing='0'>
                {$headerTable}
                {$bodyTable}
            </table>
        ";
        return $html;
    }

    private function getHeaderTable(array $headers): string
    {
        $headerHTML = '
            <thead>
                <tr>
                    <th>Email</th>
        ';

        foreach ($headers as $header) {
            $headerHTML .= '<th>' . htmlspecialchars($header) . '</th>';
        }

        $headerHTML .= '
                </tr>
            </thead>
        ';

        return $headerHTML;
    }

    private function getBodyTable(array $headers, array $result): string
    {
        $body = '<tbody>';

        foreach ($result as $email => $data) {
            $body .= '
                <tr>
                    <td>' . htmlspecialchars($email) . '</td>';

            $body .= $this->getTdsTable($headers, $data);

            $body .= '
                </tr>
            ';
        }

        $body .= '</tbody>';

        return $body;
    }

    private function getTdsTable(array $headers, array $data): string
    {
        $tds = '';

        foreach ($headers as $header) {
            $value = $data[$header] ?? '';
            $tds .= '<td>' . htmlspecialchars($this->convertationBoolToStr($value)) . '</td>';
        }

        return $tds;
    }

    private function convertationBoolToStr(bool $bool): string
    {
        return ($bool ? 'true' : 'false');
    }
}
