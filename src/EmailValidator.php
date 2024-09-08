<?php

namespace PenguinAstronaut\App;

class EmailValidator
{
    const string DEFAULT_REGEX = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/ui';

    public function __construct(private array $regexRules = [])
    {
        if (!$this->regexRules) {
            $this->regexRules = [
                self::DEFAULT_REGEX
            ];
        }
    }

    public function addRegexRule(string $regex): void
    {
        $this->regexRules[] = $regex;
    }

    public function setRegexRule(array $rules): void
    {
        $this->regexRules = $rules;
    }

    /**
     * @throws EmailValidationRegexRuleException|EmailValidationDomainException
     */
    public function validate(string $email): true
    {
        return $this->validateByRegex($email) && $this->validateByDomain($email);
    }

    /**
     * @throws EmailValidationRegexRuleException
     */
    public function validateByRegex(string $email): true
    {
        foreach ($this->regexRules as $regex) {
            if (!preg_match($regex, $email)) {
                throw new EmailValidationRegexRuleException('Email validation failed by regex: ' . $regex);
            }
        }

        return true;
    }

    /**
     * @throws EmailValidationDomainException
     */
    public function validateByDomain(string $email): true
    {
        [, $domain] = explode('@', $email);

        if (!$domain || !checkdnsrr($domain,'MX')) {
            throw new EmailValidationDomainException('Email validation failed by domain: ' . $domain);
        }

        return true;
    }
}
