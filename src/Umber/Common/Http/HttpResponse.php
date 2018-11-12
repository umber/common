<?php

declare(strict_types=1);

namespace Umber\Common\Http;

use Umber\Common\Database\Pagination\PaginatorInterface;
use Umber\Common\Exception\Http\Response\ResponseMissingHeaderException;
use Umber\Common\Exception\Http\Response\ResponseMissingPaginatorException;
use Umber\Common\Http\Header\HttpHeaderInterface;

use Symfony\Component\HttpFoundation\Response;

/**
 * A symfony request based HTTP response.
 */
final class HttpResponse implements HttpResponseInterface
{
    private $response;

    /** @var HttpHeaderInterface[] */
    private $headers = [];

    /** @var PaginatorInterface */
    private $paginator;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Return the internal response.
     */
    public function getInternalResponse(): Response
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): Response
    {
        foreach ($this->headers as $header) {
            $this->response->headers->set(
                $header->getName(),
                $header->getValue()
            );
        }

        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader(string $name): bool
    {
        return isset($this->headers[$name]);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ResponseMissingHeaderException When the custom header does not exist.
     */
    public function getHeader(string $name): HttpHeaderInterface
    {
        if (isset($this->headers[$name])) {
            return $this->headers[$name];
        }

        throw ResponseMissingHeaderException::create($name);
    }

    /**
     * {@inheritdoc}
     */
    public function setHeader(HttpHeaderInterface $header): void
    {
        $this->headers[$header->getName()] = $header;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeaders(array $headers): void
    {
        foreach ($headers as $header) {
            $this->setHeader($header);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasPaginator(): bool
    {
        return $this->paginator instanceof PaginatorInterface;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ResponseMissingPaginatorException When the paginator has not been set.
     */
    public function getPaginator(): PaginatorInterface
    {
        if ($this->paginator instanceof PaginatorInterface) {
            return $this->paginator;
        }

        throw ResponseMissingPaginatorException::create();
    }

    /**
     * {@inheritdoc}
     */
    public function setPaginator(PaginatorInterface $paginator): void
    {
        $this->paginator = $paginator;
    }
}
