<?php

namespace Otus\Service;

use Otus\Validator\DNSMXValidator;
use Otus\Validator\EmailValidator;

class EmailVerificationService
{
	public function __construct(
		private readonly EmailValidator $emailValidator,
		private readonly DNSMXValidator $dnsChecker
	)
	{
	}

	public function verifyEmails(array $emails): array
	{
		$validEmails = [];

		foreach ($emails as $email)
		{
			if ($this->emailValidator->isValidFormat($email) && $this->dnsChecker->hasMXRecord($email))
			{
				$validEmails[] = $email;
			}
		}

		return $validEmails;
	}
}