<?php

declare(strict_types=1);

namespace Umber\Common\Utility;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class JsonHttpHelper
{
    /**
     * Return the payload from a request.
     *
     * @return mixed[]
     */
    public static function request(Request $request): array
    {
        return self::json($request->getContent());
    }

    /**
     * Return the payload from a response.
     *
     * @return mixed[]
     */
    public static function response(Response $response): array
    {
        return self::json($response->getContent());
    }

    /**
     * Decode the given JSON string.
     *
     * @return mixed[]
     */
    public static function json(string $json): array
    {
        $payload = json_decode($json ?? '{}', true);

        return is_array($payload)
            ? $payload
            : [];
    }
}
