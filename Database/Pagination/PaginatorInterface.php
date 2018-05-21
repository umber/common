<?php

declare(strict_types=1);

namespace Umber\Common\Database\Pagination;

interface PaginatorInterface
{
    /**
     * The limit of results per page.
     */
    public const PAGINATION_RESULTS_PER_PAGE = 'Pagination-Results-Per-Page';

    /**
     * The count of results returned in this page.
     */
    public const PAGINATION_RESULTS_COUNT = 'Pagination-Results-Count';

    /**
     * The count of the entire result set.
     */
    public const PAGINATION_RESULTS_TOTAL = 'Pagination-Results-Total';

    /**
     * The count of pages for the result set.
     */
    public const PAGINATION_PAGES_TOTAL = 'Pagination-Pages-Total';

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
