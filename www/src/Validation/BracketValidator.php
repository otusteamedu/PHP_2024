<?php

namespace Otus\Validation;

class BracketValidator implements Validator
{
	public function isValid(string $value): bool
	{
		$stack = [];
		$map = ['(' => ')'];

		for ($i = 0, $length = strlen($value); $i < $length; $i++)
		{
			$char = $value[$i];

			if (isset($map[$char]))
			{
				$stack[] = $char;
			}
			elseif (empty($stack) || $map[array_pop($stack)] !== $char)
			{
				return false;
			}
		}

		return empty($stack);
	}
}