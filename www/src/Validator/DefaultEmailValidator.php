<?php

namespace Otus\Validator;

class DefaultEmailValidator implements EmailValidator
{

	public function isValidFormat(string $email): bool
	{
		$pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

		return preg_match($pattern, $email) === 1;
	}
}