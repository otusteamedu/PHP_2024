<?php

namespace App\Infrastructure\Controller\News\GetHtml\v1;

use App\Infrastructure\Validator\DigitalArray;
use Symfony\Component\Validator\Constraints as Assert;

class GetHtmlControllerRequest
{
    /**
     * @param int[] $idArray
     */
    public function __construct(
        #[Assert\NotBlank]
        #[DigitalArray]
        public readonly array $idArray,
    ) {
    }
}
