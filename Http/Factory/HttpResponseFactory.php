<?php

declare(strict_types=1);

namespace Umber\Common\Http\Factory;

use Umber\Common\Database\Pagination\PaginatorInterface;
use Umber\Common\Http\HttpResponse;
use Umber\Common\Http\HttpResponseInterface;

/**
 * {@inheritdoc}
 */
final class HttpResponseFactory implements HttpFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(string $type, int $status, array $data): HttpResponseInterface
    {
        switch ($type) {
            case static::TYPE_JSON:
                return $this->handleJsonResponse($status, $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setPaginationHeaders(HttpResponseInterface $response, PaginatorInterface $paginator): void
    {
        $response->setPaginator($paginator);

        $response->setHeader(PaginatorInterface::PAGINATION_RESULTS_PER_PAGE, (string) $paginator->getResultPerPageCount());
        $response->setHeader(PaginatorInterface::PAGINATION_RESULTS_COUNT, (string) $paginator->getResultSetCount());
        $response->setHeader(PaginatorInterface::PAGINATION_RESULTS_TOTAL, (string) $paginator->getResultTotalCount());
        $response->setHeader(PaginatorInterface::PAGINATION_PAGES_TOTAL, (string) $paginator->getPageTotalCount());
    }

    /**
     * Prepare a JSON response.
     *
     * @param mixed[] $data
     */
    private function handleJsonResponse(int $status, array $data): HttpResponseInterface
    {
        $response = new HttpResponse($status, json_encode($data));
        $response->setHeader(HttpResponseInterface::HEADER_CONTENT_TYPE, 'application/json');

        return $response;
    }
}
