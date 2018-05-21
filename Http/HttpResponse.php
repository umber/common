<?php

declare(strict_types=1);

namespace Umber\Common\Http;

use Umber\Common\Database\Pagination\PaginatorInterface;

use Symfony\Component\HttpFoundation\Response;

/**
 * {@inheritdoc}
 */
final class HttpResponse extends Response implements HttpResponseInterface
{
    /** @var PaginatorInterface */
    private $paginator;

    public function __construct(int $status, string $content)
    {
        parent::__construct($content, $status);
    }

    /**
     * {@inheritdoc}
     */
    public function setHeader(string $header, string $value): void
    {
        $this->headers->set($header, $value, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getPaginator(): PaginatorInterface
    {
        return $this->paginator;
    }

    /**
     * {@inheritdoc}
     */
    public function setPaginator(PaginatorInterface $paginator): void
    {
        $this->paginator = $paginator;
    }
}
