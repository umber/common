<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Http\Resource;

use Umber\Common\Exception\Http\AbstractHttpException;

use Symfony\Component\HttpFoundation\Response;

/**
 * {@inheritdoc}
 */
final class ResourceNotFoundException extends AbstractHttpException
{
    public const E_RESOURCE_NOT_FOUND = 'http.resource_not_found';

    /**
     * @return ResourceNotFoundException
     */
    public static function create(string $id): self
    {
        $parameters = [
            'id' => $id,
        ];

        return new self(self::E_RESOURCE_NOT_FOUND, $parameters, Response::HTTP_NOT_FOUND);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The resource ("{{id}}") requested was not found.',
        ];
    }
}
