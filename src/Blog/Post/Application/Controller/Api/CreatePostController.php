<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\Controller\Api;

use App\Blog\Post\Application\Event\UserCreatingPostVerifyEvent;
use App\Blog\Post\Application\Query\FindPostQuery;
use Psr\EventDispatcher\EventDispatcherInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class CreatePostController
{
    use HandleTrait;

    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        MessageBusInterface $messageBus,
    ) {
        $this->messageBus = $messageBus;
    }

    #[Route(path: '/post', methods: [Request::METHOD_POST])]
    public function __invoke(Request $request): JsonResponse
    {
        $parameters = \Safe\json_decode($request->getContent(),true);

        $id = Uuid::uuid4();

        $this->eventDispatcher->dispatch(new UserCreatingPostVerifyEvent(
            $id,
            $parameters['title'],
            $parameters['body'],
            Uuid::fromString($parameters['authorId']),
        ));

        $article = $this->handle(new FindPostQuery($id));

        return JsonResponse::fromJsonString($article);
    }
}