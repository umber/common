<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Http\Resource;

use Umber\Common\Exception\AbstractMessageRuntimeException;

use Umber\Http\Hint\HttpAwareExceptionInterface;
use Umber\Http\Hint\HttpCanonicalAwareExceptionInterface;

use Symfony\Component\HttpFoundation\Response;

use Throwable;

/**
 * A resource not found exception.
 */
final class ResourceNotFoundException extends AbstractMessageRuntimeException implements
    HttpCanonicalAwareExceptionInterface,
    HttpAwareExceptionInterface
{
    /**
     * @return ResourceNotFoundException
     */
    public static function create(string $id, ?Throwable $previous = null): self
    {
        $parameters = [
            'id' => $id,
        ];

        return new self($parameters, null, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public static function getCanonicalCode(): string
    {
        return 'http.resource.not_found';
    }

    /**
     * {@inheritdoc}
     */
    public static function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The resource "{{id}}" does not exist.',
        ];
    }
}
