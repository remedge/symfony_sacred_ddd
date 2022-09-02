<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\Query;

use Ramsey\Uuid\UuidInterface;

final class FindPostQuery
{
    private UuidInterface $postId;

    public function __construct(UuidInterface $postId)
    {
        $this->postId = $postId;
    }

    public function getPostId(): UuidInterface
    {
        return $this->postId;
    }
}