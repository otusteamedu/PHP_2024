<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Entity;

use function array_values;

final class UserCollection
{
    /**
     * @var array<string, User>
     */
    private array $items = [];

    public function __construct(User ...$users)
    {
        foreach ($users as $user) {
            $this->add($user);
        }
    }

    public function add(User $user): void
    {
        if (!$this->has($user->getUuid())) {
            $this->items[$user->getUuid()] = $user;
        }
    }

    public function all(): array
    {
        return array_values($this->items);
    }

    public function has(string $uuid): bool
    {
        return isset($this->items[$uuid]);
    }

    public function get(string $uuid): ?User
    {
        return $this->items[$uuid] ?? null;
    }

    public function addAll(User $user, User ...$users): void
    {
        $users[] = $user;
        foreach ($users as $item) {
            $this->add($item);
        }
    }
}
