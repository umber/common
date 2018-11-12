<?php

declare(strict_types=1);

namespace Umber\Common\Http\Header\Generator;

use Umber\Common\Http\Enum\HttpHeaderEnum;
use Umber\Common\Http\Header\Configuration\AccessControlConfiguration;
use Umber\Common\Http\Header\HttpHeader;
use Umber\Common\Http\HttpResponseInterface;

/**
 * A response header generator for creating additional common headers.
 */
final class AdditionalResponseHeaderGenerator
{
    /**
     * Generate additional headers based on entities attached.
     *
     * For example add pagination headers.
     */
    public function generate(
        HttpResponseInterface $response,
        ?AccessControlConfiguration $configuration = null
    ): void {
        if ($response->hasPaginator()) {
            $paginator = $response->getPaginator();

            $response->setHeaders([
                new HttpHeader(HttpHeaderEnum::PAGINATION_RESULTS_PER_PAGE, (string) $paginator->getResultPerPageCount()),
                new HttpHeader(HttpHeaderEnum::PAGINATION_RESULTS_COUNT, (string) $paginator->getResultSetCount()),
                new HttpHeader(HttpHeaderEnum::PAGINATION_RESULTS_TOTAL, (string) $paginator->getResultTotalCount()),
                new HttpHeader(HttpHeaderEnum::PAGINATION_PAGES_TOTAL, (string) $paginator->getPageTotalCount()),
            ]);
        }

        if (!($configuration instanceof AccessControlConfiguration)) {
            return;
        }

        $this->handleAccessControl($response, $configuration);
    }

    /**
     * Handle access control headers for the request.
     */
    private function handleAccessControl(
        HttpResponseInterface $response,
        AccessControlConfiguration $configuration
    ): void {
        $response->setHeaders([
            new HttpHeader(HttpHeaderEnum::ACCESS_CONTROL_MAX_AGE, (string) $configuration->getAge(), false),
            new HttpHeader(HttpHeaderEnum::ACCESS_CONTROL_ALLOW_ORIGIN, $configuration->getOrigin(), false),
        ]);

        // If the configuration contains methods then add them.
        // This header should not be present if nothing is to be shown.
        if (count($configuration->getMethods()) > 0) {
            $methods = implode(', ', $configuration->getMethods());
            $response->setHeader(new HttpHeader(HttpHeaderEnum::ACCESS_CONTROL_ALLOW_METHODS, $methods, false));
        }

        $this->handleAccessControlAllowHeader($response);
        $this->handleAccessControlExposeHeader($response);
    }

    /**
     * Handle access control allow header.
     */
    private function handleAccessControlAllowHeader(HttpResponseInterface $response): void
    {
        $headers = [
            HttpHeaderEnum::AUTHORIZATION,
            HttpHeaderEnum::CONTENT_TYPE,
        ];

        sort($headers);

        $headers = array_unique($headers);
        $headers = implode(', ', $headers);

        $response->setHeader(new HttpHeader(HttpHeaderEnum::ACCESS_CONTROL_ALLOW_HEADERS, $headers, false));
    }

    /**
     * Handle access control expose header.
     */
    private function handleAccessControlExposeHeader(HttpResponseInterface $response): void
    {
        $headers = [];

        // Collect all the headers set against the response.
        // These will be mentioned in the allow headers.
        foreach ($response->getHeaders() as $header) {
            if ($header->isExposed() === false) {
                continue;
            }

            $headers[] = $header->getName();
        }

        sort($headers);

        $headers = array_unique($headers);
        $headers = implode(', ', $headers);

        $response->setHeader(new HttpHeader(HttpHeaderEnum::ACCESS_CONTROL_EXPOSE_HEADERS, $headers, false));
    }
}
