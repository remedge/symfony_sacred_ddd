<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Http;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class UuidValueResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return !$argument->isVariadic() && is_a((string) $argument->getType(), UuidInterface::class, true);
    }

    /**
     * @return iterable<UuidInterface>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$this->supports($request, $argument)) {
            throw new \RuntimeException('Unsupported method call');
        }

        yield Uuid::fromString((string) $request->attributes->get($argument->getName()));
    }
}
