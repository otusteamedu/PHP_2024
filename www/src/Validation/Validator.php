<?php

namespace Otus\Validation;

interface Validator
{
	public function isValid(string $value): bool;
}