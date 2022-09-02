<?php

declare(strict_types=1);

namespace App\Blog\User\Domain\Event;

use App\Blog\User\Domain\Entity\Email;
use App\Shared\Event\DomainEventInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class UserCreatedEvent extends Event implements DomainEventInterface
{
    private UuidInterface $userId;
    private Email $email;

    public function __construct(UuidInterface $userId, Email $email)
    {
        $this->userId = $userId;
        $this->email = $email;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
