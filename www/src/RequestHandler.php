<?php

namespace Otus;

class RequestHandler
{
	public function __construct(private readonly BracketValidator $validator)
	{
	}

	public function handleRequest(): void
	{
		$string = $_POST['string'] ?? '';

		if (empty($string))
		{
			$this->sendResponse(400, '<div style="color: darkred; display: inline">Bad Request - Empty</div>');

			return;
		}

		if ($this->validator->isValid($string))
		{
			$this->sendResponse(200, '<div style="color: green; display: inline">OK</div>');
		}
		else
		{
			$this->sendResponse(400, '<div style="color: darkred; display: inline">Bad Request - Invalid</div>');
		}
	}

	private function sendResponse(int $code, string $message): void
	{
		http_response_code($code);
		echo $code . ': ' . $message . '</br>';
	}
}