<?php

namespace App\Blog\Post\Domain\Repository;

use App\Blog\Post\Domain\Entity\Post;
use Ramsey\Uuid\UuidInterface;

interface PostRepositoryInterface
{
    public function findById(UuidInterface $id): ?Post;

    public function save(Post $post): void;
}
