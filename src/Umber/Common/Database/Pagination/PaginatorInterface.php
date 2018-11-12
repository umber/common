<?php

declare(strict_types=1);

namespace Umber\Common\Database\Pagination;

use Umber\Common\Http\Enum\HttpHeaderEnum;

interface PaginatorInterface
{
    /**
     * The limit of results per page.
     *
     * @deprecated Use the HttpHeaderEnum instead.
     */
    public const PAGINATION_RESULTS_PER_PAGE = HttpHeaderEnum::PAGINATION_RESULTS_PER_PAGE;

    /**
     * The count of results returned in this page.
     *
     * @deprecated Use the HttpHeaderEnum instead.
     */
    public const PAGINATION_RESULTS_COUNT = HttpHeaderEnum::PAGINATION_RESULTS_COUNT;

    /**
     * The count of the entire result set.
     *
     * @deprecated Use the HttpHeaderEnum instead.
     */
    public const PAGINATION_RESULTS_TOTAL = HttpHeaderEnum::PAGINATION_RESULTS_TOTAL;

    /**
     * The count of pages for the result set.
     *
     * @deprecated Use the HttpHeaderEnum instead.
     */
    public const PAGINATION_PAGES_TOTAL = HttpHeaderEnum::PAGINATION_PAGES_TOTAL;

    public function getResultPerPageCount(): int;

    public function getResultSetCount(): int;

    public function getResultTotalCount(): int;

    public function getPageTotalCount(): int;

    public function getCurrentPageNumber(): int;

    /**
     * @return mixed[]
     */
    public function asArray(): array;
}
