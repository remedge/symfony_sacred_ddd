<?php

declare(strict_types=1);

namespace App\Blog\User\Application\Event;

use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class OnUserVerifiedForPostEvent extends Event
{
    public function __construct(
        public readonly UuidInterface $id,
        public readonly string $title,
        public readonly string $body,
        public readonly UuidInterface $authorId,
    ) {
    }
}
