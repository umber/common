<?php

declare(strict_types=1);

namespace Umber\Common\Test;

use Umber\Common\Database\Pagination\PaginatorInterface;

use Symfony\Component\HttpFoundation\Response;

/**
 * A trait that adds a series of helper assertions for functional testing.
 *
 * @mixin \PHPUnit\Framework\TestCase
 */
trait SymfonyFunctionalAssertionTrait
{
    /**
     * Assert the response status code.
     */
    protected static function assertResponseApi(Response $response, int $status): void
    {
        $message = $response->getContent();

        /** @var array|null $json */
        $json = json_decode($message, true);

        if (is_array($json)) {
            self::assertEquals('application/json', $response->headers->get('Content-Type'), $message);

            $message = json_encode($json, JSON_PRETTY_PRINT);
        }

        self::assertEquals($status, $response->getStatusCode(), $message);
    }

    /**
     * Assert the response error.
     */
    protected static function assertResponseError(Response $response, string $message): void
    {
        /** @var array|null $json */
        $json = json_decode($response->getContent(), true);

        self::assertEquals($message, $json['error']['message']);
    }

    /**
     * Assert the response pagination headers.
     */
    protected static function assertResponsePagination(Response $response, int $total): void
    {
        $headers = $response->headers;

        self::assertTrue($headers->has(PaginatorInterface::PAGINATION_RESULTS_TOTAL));
        self::assertTrue($headers->has(PaginatorInterface::PAGINATION_RESULTS_COUNT));
        self::assertTrue($headers->has(PaginatorInterface::PAGINATION_RESULTS_PER_PAGE));
        self::assertTrue($headers->has(PaginatorInterface::PAGINATION_PAGES_TOTAL));

        $results = (int) $headers->get(PaginatorInterface::PAGINATION_RESULTS_TOTAL, 0);

        self::assertEquals($total, $results, 'Collection results total header incorrect');
        self::assertCount($total, json_decode($response->getContent(), true), 'Collection results total payload incorrect');
    }

    /**
     * Assert the response pagination headers.
     */
    protected static function assertResponseNotPaginated(Response $response): void
    {
        $headers = $response->headers;

        self::assertFalse($headers->has(PaginatorInterface::PAGINATION_RESULTS_TOTAL));
        self::assertFalse($headers->has(PaginatorInterface::PAGINATION_RESULTS_COUNT));
        self::assertFalse($headers->has(PaginatorInterface::PAGINATION_RESULTS_PER_PAGE));
        self::assertFalse($headers->has(PaginatorInterface::PAGINATION_PAGES_TOTAL));
    }

    /**
     * Assert the response pagination headers.
     *
     * @param mixed[] $expected
     */
    protected static function assertResponseData(Response $response, array $expected): void
    {
        $json = json_decode($response->getContent(), true);

        self::assertNotNull($json, 'The response did not have valid json');
        self::assertArraySubset($expected, $json);
    }
}
