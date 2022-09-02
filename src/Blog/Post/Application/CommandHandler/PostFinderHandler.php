<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\CommandHandler;

use App\Blog\Post\Application\Query\FindPostQuery;
use App\Blog\Post\Domain\Repository\PostRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class PostFinderHandler implements MessageHandlerInterface
{
    private PostRepositoryInterface $postRepository;
    private SerializerInterface $serializer;

    public function __construct(
        PostRepositoryInterface $postRepository,
        SerializerInterface $serializer,
    ) {
        $this->postRepository = $postRepository;
        $this->serializer = $serializer;
    }

    public function __invoke(FindPostQuery $findPostQuery): string
    {
        $articleId = $findPostQuery->getPostId();

        $article = $this->postRepository->find($articleId);

        $result = $this->serializer->normalize($article);

        return \Safe\json_encode($result);
    }
}