<?php

declare(strict_types=1);

namespace App\Validator;

class ValidationChain
{
    /** @var ValidatorInterface[]  */
    protected array $validators;
    /** @var mixed  */
    protected mixed $data;

    /**
     * @param ValidatorInterface $validator
     * @return $this
     */
    public function addValidator(ValidatorInterface $validator): static
    {
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * @param mixed $data
     * @return void
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function validate():void
    {
        foreach ($this->validators as $validator) {
            $validator->setData($this->data);
            if (!$validator->isValid()) {
                throw new ValidationException($validator->getMessage());
            }
        }
    }
}
