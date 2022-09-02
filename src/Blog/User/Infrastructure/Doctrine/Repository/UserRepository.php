<?php

declare(strict_types=1);

namespace App\Blog\User\Infrastructure\Doctrine\Repository;

use App\Blog\User\Domain\Entity\User;
use App\Blog\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        try {
            $this->_em->persist($user);
            $this->_em->flush();
        } catch (\Throwable $e) {
            dump($e); exit;
        }
    }

    public function findById($id): ?User
    {
        return parent::find($id);
    }

    public function findAllUsers(): array
    {
        return parent::findAll();
    }
}