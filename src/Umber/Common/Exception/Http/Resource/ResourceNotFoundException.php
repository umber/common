<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Http\Resource;

use Umber\Common\Exception\Hint\CanonicalAwareExceptionInterface;
use Umber\Common\Exception\Hint\HttpAwareExceptionInterface;

use Umber\Exception\Message\AbstractMessageRuntimeException;

use Symfony\Component\HttpFoundation\Response;

/**
 * A resource not found exception.
 */
final class ResourceNotFoundException extends AbstractMessageRuntimeException implements
    CanonicalAwareExceptionInterface,
    HttpAwareExceptionInterface
{
    /**
     * @return ResourceNotFoundException
     */
    public static function create(string $id): self
    {
        return new self([
            'id' => $id,
        ]);
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
            'The resource ("{{id}}") does not exist.',
        ];
    }
}
