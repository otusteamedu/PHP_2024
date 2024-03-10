<?php

namespace Otus\Validator;

interface DNSMXValidator
{
	public function hasMXRecord(string $email): bool;
}