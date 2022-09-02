<?php

declare(strict_types=1);

namespace App\Shared\ValueObject;

use Ramsey\Uuid\UuidInterface;

abstract class AggregateRootId
{
    public function __construct(
        protected UuidInterface $uuid
    ) {
    }

    public function getValue(): UuidInterface
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }
}
