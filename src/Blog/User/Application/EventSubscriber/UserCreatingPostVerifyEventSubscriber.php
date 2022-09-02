<?php

declare(strict_types=1);

namespace App\Blog\User\Application\EventSubscriber;

use App\Blog\Post\Application\Event\UserCreatingPostVerifyEvent;
use App\Blog\User\Application\Event\OnUserVerifiedForPostEvent;
use App\Blog\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class UserCreatingPostVerifyEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatingPostVerifyEvent::class => 'validateUser',
        ];
    }

    public function validateUser(UserCreatingPostVerifyEvent $event): void
    {
        $user = $this->userRepository->findById($event->authorId);
        if (!$user) {
            throw new \InvalidArgumentException('author not found');
        }

        if (!\in_array('ROLE_EDITOR', $user->getRoles(), true)) {
            throw new \InvalidArgumentException('the author does not have the necessary permissions');
        }

        $this->eventDispatcher->dispatch(new OnUserVerifiedForPostEvent(
            $event->id,
            $event->title,
            $event->body,
            $event->authorId,
        ));
    }
}
