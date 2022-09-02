<?php

declare(strict_types=1);

namespace App\Blog\User\Domain\Entity;

use App\Blog\User\Domain\Event\UserCreatedEvent;
use App\Shared\Aggregate\AggregateRoot;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends AggregateRoot implements UserInterface, PasswordAuthenticatedUserInterface
{
    private UuidInterface $id;

    private string $email;

    private array $roles = [];

    private string $password;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public static function registerUser(Email $email, array $roles, string $password): self
    {
        $userId = Uuid::uuid4();
        $user = new User($userId);
        $user->setEmail($email->getValue());
        $user->setRoles($roles);
        $user->setPassword($password);

        $user->recordDomainEvent(new UserCreatedEvent($userId, $email));

        return $user;
    }
}
