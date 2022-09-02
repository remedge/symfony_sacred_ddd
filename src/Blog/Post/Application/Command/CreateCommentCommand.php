<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\Command;

use Ramsey\Uuid\UuidInterface;

final class CreateCommentCommand
{
    public function __construct(
        public readonly UuidInterface $id,
        public readonly UuidInterface $postId,
        public readonly UuidInterface $authorId,
        public readonly string $message
    ) {
    }
}