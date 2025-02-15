<?php

namespace App\Infrastructure\Controller\Payload;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ReportFeedControllerRequest
{
    /**
     * @param int[] $ids
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\All([
                new Assert\Type('integer'),
            ]
        )]
        public array $ids = [],
    ) {
    }

}
