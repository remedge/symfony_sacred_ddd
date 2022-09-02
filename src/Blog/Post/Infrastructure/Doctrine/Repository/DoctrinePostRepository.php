<?php

declare(strict_types=1);

namespace App\Blog\Post\Infrastructure\Doctrine\Repository;

use App\Blog\Post\Domain\Entity\Post;
use App\Blog\Post\Domain\Repository\PostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class DoctrinePostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findById(UuidInterface $id): ?Post
    {
        return parent::find($id);
    }

    public function save(Post $post): void
    {
        $this->_em->persist($post);
        $this->_em->flush();
    }
}