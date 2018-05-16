<?php

declare(strict_types=1);

namespace Umber\Common\Http\Factory;

use Umber\Common\Database\Pagination\PaginatorInterface;
use Umber\Common\Http\HttpResponseInterface;

/**
 * A factory for creating HTTP responses.
 */
interface HttpFactoryInterface
{
    public const TYPE_HTML = 'html';
    public const TYPE_JSON = 'json';
    public const TYPE_XML = 'xml';

    /**
     * Create a HTTP response.
     *
     * @param mixed[] $data
     */
    public function create(string $type, int $status, array $data): HttpResponseInterface;

    /**
     * Set pagination headers against the given request.
     */
    public function setPaginationHeaders(HttpResponseInterface $response, PaginatorInterface $paginator): void;
}
