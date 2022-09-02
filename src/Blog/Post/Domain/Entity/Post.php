<?php

declare(strict_types=1);

namespace App\Blog\Post\Domain\Entity;

use App\Blog\Post\Domain\Event\PostCreatedEvent;
use App\Shared\Aggregate\AggregateRoot;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class Post extends AggregateRoot
{
    private UuidInterface $id;
    private UuidInterface $authorId;

    public function __construct(
        PostId $id,
        AuthorId $authorId,
        private string $title,
        private string $body,
        private DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt,
    )
    {
        $this->id = $id->getValue();
        $this->authorId = $authorId->getValue();
    }

    public function getId(): PostId
    {
        return new PostId($this->id);
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthorId(): AuthorId
    {
        return new AuthorId($this->authorId);
    }

    public function setAuthor(AuthorId $authorId): self
    {
        $this->authorId = $authorId->getValue();

        return $this;
    }

    public static function create(
        PostId $postId,
        string $title,
        string $body,
        AuthorId $authorId,
    ): self {
        $article = new self(
            id: $postId,
            authorId: $authorId,
            title: $title,
            body: $body,
            createdAt: new DateTimeImmutable('now'),
            updatedAt: new DateTimeImmutable('now')
        );

        $article->recordDomainEvent(new PostCreatedEvent($postId));

        return $article;
    }
}