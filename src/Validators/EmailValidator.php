<?php

declare(strict_types=1);

namespace Main\Validators;

class EmailValidator extends AbstractValidator implements Validator
{
    protected $pattern = '/^[a-zA-Zа-яА-Я0-9\.\_\-]+@[a-zA-Zа-яА-Я0-9.-]+\.[a-zA-Zа-яА-Я]{2,6}$/u';

    public function validate(): bool
    {
        if (!$this->validateType()) {
            return false;
        }

        if (!$this->validateRegExp()) {
            return false;
        }

        if (!$this->validateDns()) {
            return false;
        }

        return true;
    }

    protected function validateType(): bool
    {
        if (!is_string($this->value)) {
            $this->errorMessage = "Неверный формат email адреса";
            return false;
        }
        return true;
    }


    protected function validateRegExp(): bool
    {
        if (!preg_match($this->pattern, $this->value)) {
            $this->errorMessage = "Неверный формат email адреса";
            return false;
        }
        return true;
    }

    protected function validateDns(): bool
    {
        $domain = explode('@', $this->value)[1];
        if (!checkdnsrr($domain, 'MX')) {
            $this->errorMessage = "Отсутствуют MX записи для домена";
            return false;
        }
        return true;
    }
}
