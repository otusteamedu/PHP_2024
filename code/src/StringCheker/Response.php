<?php

declare(strict_types=1);

namespace Otus\Balancer\StringCheker;

class Response
{
	public function success()
	{
		echo "string is <b>VALID</b>";
	}

	public function error(?string $message = null)
	{
		http_response_code(400);
		echo $message ?? 'string is <b>INVALID</b>';
	}
}
