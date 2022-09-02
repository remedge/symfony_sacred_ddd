<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\Controller\Api;

use App\Blog\Post\Application\Query\FindPostQuery;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class GetPostController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus) {
        $this->messageBus = $messageBus;
    }

    #[Route(path: '/post/{id}', methods: [Request::METHOD_GET])]
    public function __invoke(UuidInterface $id): JsonResponse
    {
        $article = $this->handle(new FindPostQuery($id));

        return JsonResponse::fromJsonString($article);
    }
}