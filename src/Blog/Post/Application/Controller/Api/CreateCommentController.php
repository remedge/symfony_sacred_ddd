<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\Controller\Api;

use App\Blog\Post\Application\Command\CreateCommentCommand;
use Psr\EventDispatcher\EventDispatcherInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class CreateCommentController
{
    use HandleTrait;

    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        MessageBusInterface $messageBus,
    ) {
        $this->messageBus = $messageBus;
    }

    #[Route(path: '/comment', methods: [Request::METHOD_POST])]
    public function __invoke(Request $request): JsonResponse
    {
        $parameters = \Safe\json_decode($request->getContent(),true);

        $id = Uuid::uuid4();

        $comment = $this->handle($createCommentCommand);

        $article = $this->handle(new FindCommentQuery($id));

        return JsonResponse::fromJsonString($article);
    }
}