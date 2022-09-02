<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\EventSubscriber;

use App\Blog\Post\Application\Command\CreatePostCommand;
use App\Blog\User\Application\Event\OnUserVerifiedForPostEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class OnUserVerifiedForPostEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OnUserVerifiedForPostEvent::class => 'createArticle',
        ];
    }

    public function createArticle(OnUserVerifiedForPostEvent $event): void
    {
        $createArticleCommand = new CreatePostCommand(
            id: $event->id,
            title: $event->title,
            body: $event->body,
            authorId: $event->authorId
        );
        $this->messageBus->dispatch($createArticleCommand);
    }
}
