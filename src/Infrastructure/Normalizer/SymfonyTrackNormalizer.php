<?php

declare(strict_types=1);

namespace App\Infrastructure\Normalizer;

use App\Domain\Entity\Track;
use App\Domain\Service\Decorator\TrackDurationAddDescription;
use App\Domain\Service\INormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SymfonyTrackNormalizer implements INormalizer, NormalizerInterface
{
    /**
     * @param Track $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'author' => $object->getAuthor(),
            'genre' => $object->getGenre()->getValue(),
            'duration' => (new TrackDurationAddDescription($object->getDuration()))->getFormatedDuration(),
        ];
    }

    public function supportsNormalization(mixed $data,?string $format = null, array $context = []): bool
    {
        return $data instanceof Track;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Track::class => true,
        ];
    }
}
