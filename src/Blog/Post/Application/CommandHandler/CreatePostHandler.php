<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\CommandHandler;

use App\Blog\Post\Application\Command\CreatePostCommand;
use App\Blog\Post\Domain\Entity\AuthorId;
use App\Blog\Post\Domain\Entity\Post;
use App\Blog\Post\Domain\Entity\PostId;
use App\Blog\Post\Domain\Repository\PostRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreatePostHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly PostRepositoryInterface  $postRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(CreatePostCommand $createPostCommand): void
    {
        $post = Post::create(
            new PostId($createPostCommand->id),
            $createPostCommand->title,
            $createPostCommand->body,
            new AuthorId($createPostCommand->authorId),
        );

        $this->postRepository->save($post);

        foreach ($post->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}
