<?php

declare(strict_types=1);

namespace App\Blog\User\Domain\Repository;

use App\Blog\User\Domain\Entity\User;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function findById(UuidInterface $id): ?User;

    /**
     * @return array<User>
     */
    public function findAllUsers(): array;

    public function save(User $user): void;
}
