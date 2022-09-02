<?php

declare(strict_types=1);

namespace App\Blog\Post\Domain\Event;

use App\Blog\Post\Domain\Entity\PostId;
use App\Shared\Event\DomainEventInterface;
use DateTimeImmutable;
use Symfony\Contracts\EventDispatcher\Event;

final class PostCreatedEvent extends Event implements DomainEventInterface
{
    protected DateTimeImmutable $occur;
    protected PostId $postId;

    public function __construct(PostId $postId)
    {
        $this->postId = $postId;
        $this->occur = new DateTimeImmutable();
    }

    public function getArticleId(): PostId
    {
        return $this->postId;
    }

    public function getOccur(): DateTimeImmutable
    {
        return $this->occur;
    }
}
