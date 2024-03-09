<?php

namespace Otus;

class BracketValidator
{
	public function isValid(string $string): bool
	{
		$stack = [];
		$map = ['(' => ')'];

		for ($i = 0, $length = strlen($string); $i < $length; $i++)
		{
			$char = $string[$i];

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