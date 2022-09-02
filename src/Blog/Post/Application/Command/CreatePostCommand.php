<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\Command;

use Ramsey\Uuid\UuidInterface;

final class CreatePostCommand
{
    public function __construct(
        public readonly UuidInterface $id,
        public readonly string $title,
        public readonly string $body,
        public readonly UuidInterface $authorId
    ) {
    }
}
