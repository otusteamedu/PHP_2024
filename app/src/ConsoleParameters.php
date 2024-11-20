<?php

declare(strict_types=1);

namespace Dsergei\Hw11;

readonly class ConsoleParameters
{
    public ConsoleParametersDto $dto;

    public function __construct()
    {
        $options = getopt('', ['index:', 'search:', 'minPrice:', 'maxPrice:', 'category:']);
        if (!is_array($options)) {
            throw new \DomainException('Options must be transfer');
        }
        if (empty($options['index'])) {
            throw new \DomainException('Option index is required');
        }
        if (!isset($options['search'])) {
            $options['search'] = '';
        }
        if (!isset($options['minPrice'])) {
            $options['minPrice'] = 0;
        }
        if (!isset($options['maxPrice'])) {
            $options['maxPrice'] = 0;
        }
        if (!isset($options['category'])) {
            $options['category'] = '';
        }

        $options['minPrice'] = (float)$options['minPrice'];
        $options['maxPrice'] = (float)$options['maxPrice'];

        $this->dto = new ConsoleParametersDto(...$options);
    }
}
