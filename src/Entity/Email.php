<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\EmailStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'emails')]
final class Email
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string')]
        public readonly string $id,

        #[ORM\Column(type: 'string', enumType: EmailStatus::class)]
        public EmailStatus $status,

        #[ORM\Column(name: 'from_email', type: 'string', length: 255)]
        public readonly string $from,

        #[ORM\Column(name: 'to_email', type: 'string', length: 255)]
        public readonly string $to,

        #[ORM\Column(type: 'text')]
        public readonly string $text,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status->value,
            'from' => $this->from,
            'to' => $this->to,
            'text' => $this->text,
        ];
    }
}
