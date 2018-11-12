<?php

declare(strict_types=1);

namespace Umber\Common\Http\Enum;

final class HttpHeaderEnum
{
    public const ORIGIN = 'Origin';
    public const AUTHORIZATION = 'Authorization';
    public const CONTENT_TYPE = 'Content-Type';

    /**
     * This header gives the value in seconds for how long the response to the
     * pre-flight request can be cached for without sending another pre-flight
     * request. Note that each browser has a maximum internal value that takes
     * precedence when the this header is greater.
     *
     * @example 86400 seconds is 24 hours.
     */
    public const ACCESS_CONTROL_MAX_AGE = 'Access-Control-Max-Age';

    /**
     * The HTTP method being pre-flighted.
     */
    public const ACCESS_CONTROL_REQUEST_METHOD = 'Access-Control-Request-Method';

    /**
     * The origin allowed to access this endpoint.
     */
    public const ACCESS_CONTROL_ALLOW_ORIGIN = 'Access-Control-Allow-Origin';

    /**
     * The origin can send these headers.
     */
    public const ACCESS_CONTROL_ALLOW_HEADERS = 'Access-Control-Allow-Headers';

    /**
     * The origin can send these HTTP methods.
     */
    public const ACCESS_CONTROL_ALLOW_METHODS = 'Access-Control-Allow-Methods';

    /**
     * The origin can access these headers in the response.
     */
    public const ACCESS_CONTROL_EXPOSE_HEADERS = 'Access-Control-Expose-Headers';

    /**
     * A pagination header for the limit of results per page.
     */
    public const PAGINATION_RESULTS_PER_PAGE = 'Pagination-Results-Per-Page';

    /**
     * A pagination header for the count of results returned in this page.
     */
    public const PAGINATION_RESULTS_COUNT = 'Pagination-Results-Count';

    /**
     * A pagination header for the count of the entire result set.
     */
    public const PAGINATION_RESULTS_TOTAL = 'Pagination-Results-Total';

    /**
     * A pagination header for the count of pages for the result set.
     */
    public const PAGINATION_PAGES_TOTAL = 'Pagination-Pages-Total';
}
