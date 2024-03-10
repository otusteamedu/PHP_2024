<?php

namespace Otus\Validator;

class DefaultDNSMXValidator implements DNSMXValidator
{

	public function hasMXRecord(string $email): bool
	{
		$domain = substr(strrchr($email, '@'), 1);

		return checkdnsrr($domain);
	}
}