<?php

declare(strict_types=1);

namespace App\Infrastructure\Normalizer;

use App\Domain\Entity\News;
use App\Domain\Service\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as SymfonyNormalizerInterface;

class SymfonyNewsNormalizer implements NormalizerInterface, SymfonyNormalizerInterface
{
    /**
     * @param News $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'date' => $object->getCreatedAt()->format('Y-m-d'),
            'url' => $object->getUrl()->getValue(),
            'title' => $object->getTitle()->getValue(),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof News;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            News::class => true,
        ];
    }
}
