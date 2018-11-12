<?php

declare(strict_types=1);

namespace Umber\Common\Http;

use Umber\Common\Database\Pagination\PaginatorInterface;
use Umber\Common\Exception\Http\Response\ResponseMissingHeaderException;
use Umber\Common\Exception\Http\Response\ResponseMissingPaginatorException;
use Umber\Common\Http\Header\HttpHeaderInterface;

/**
 * A HTTP response wrapper.
 */
interface HttpResponseInterface
{
    /**
     * Build the response.
     *
     * @return mixed
     */
    public function build();

    /**
     * Check a custom header exists by name.
     */
    public function hasHeader(string $name): bool;

    /**
     * Return a custom header by name.
     *
     * @throws ResponseMissingHeaderException When the custom header does not exist.
     */
    public function getHeader(string $name): HttpHeaderInterface;

    /**
     * Set a custom header.
     */
    public function setHeader(HttpHeaderInterface $header): void;

    /**
     * Return all custom headers.
     *
     * @return HttpHeaderInterface[]
     */
    public function getHeaders(): array;

    /**
     * Set many headers.
     *
     * @param HttpHeaderInterface[] $headers
     */
    public function setHeaders(array $headers): void;

    /**
     * Check if a paginator has been set against the response.
     */
    public function hasPaginator(): bool;

    /**
     * Return the paginator against the response.
     *
     * @throws ResponseMissingPaginatorException When the paginator has not been set.
     */
    public function getPaginator(): PaginatorInterface;

    /**
     * Set a paginator against the response.
     */
    public function setPaginator(PaginatorInterface $paginator): void;
}
