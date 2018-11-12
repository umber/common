<?php

declare(strict_types=1);

namespace Umber\Common\Http;

use Umber\Common\Database\Pagination\PaginatorInterface;
use Umber\Common\Http\Factory\HttpFactoryInterface;
use Umber\Common\Serializer\SerializerInterface;

use Symfony\Component\HttpFoundation\Response;

/**
 * A helper for generating common HTTP responses.
 */
class HttpResponseGenerator
{
    private $factory;
    private $serializer;
    private $type;

    public function __construct(HttpFactoryInterface $factory, SerializerInterface $serializer, string $type)
    {
        $this->factory = $factory;
        $this->serializer = $serializer;
        $this->type = $type;
    }

    /**
     * Generate a HTTP response.
     *
     * @param mixed|mixed[]|PaginatorInterface $data
     * @param string[] $groups
     */
    public function generate(int $status, $data, array $groups): HttpResponseInterface
    {
        $paginator = $data;

        if ($paginator instanceof PaginatorInterface) {
            $data = $paginator->asArray();
        }

        // Only serialise when data is not null.
        // 204 NO CONTENT requests will have a null data.
        if ($data !== null) {
            $data = $this->serializer->serialize($data, $groups);
        }

        $response = $this->factory->create($this->type, $status, $data);

        if ($paginator instanceof PaginatorInterface) {
            $response->setPaginator($paginator);
        }

        return $response;
    }

    /**
     * Generate a 200 OK.
     *
     * @param mixed|mixed[]|PaginatorInterface $data
     * @param string[] $groups
     */
    public function ok($data, array $groups = []): HttpResponseInterface
    {
        return $this->generate(Response::HTTP_OK, $data, $groups);
    }

    /**
     * Generate a 204 NO CONTENT.
     */
    public function noContent(): HttpResponseInterface
    {
        return $this->generate(Response::HTTP_NO_CONTENT, null, []);
    }
}
