<?php

namespace Otus\Validator;

interface EmailValidator
{
	public function isValidFormat(string $email): bool;
}