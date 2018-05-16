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
     * {@inheritdoc}
     *
     * @param string|array|PaginatorInterface $data
     * @param string[] $groups
     *
     * @return HttpResponseInterface
     */
    public function generate(int $status, $data, array $groups): HttpResponseInterface
    {
        $paginator = $data;

        if ($paginator instanceof PaginatorInterface) {
            $data = $paginator->asArray();
        }

        $data = $this->serializer->serialize($data, $groups);
        $response = $this->factory->create($this->type, $status, $data);

        if ($paginator instanceof PaginatorInterface) {
            $this->factory->setPaginationHeaders($response, $paginator);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     *
     * @param string|array|PaginatorInterface $data
     * @param string[] $groups
     *
     * @return HttpResponseInterface
     */
    public function ok($data, array $groups = []): HttpResponseInterface
    {
        return $this->generate(Response::HTTP_OK, $data, $groups);
    }
}
