<?php

declare(strict_types=1);

namespace Umber\Common\Http;

use Umber\Common\Database\Pagination\PaginatorInterface;

interface HttpResponseInterface
{
    public const HEADER_CONTENT_TYPE = 'Content-Type';

    public function setHeader(string $header, string $value): void;

    public function setPaginator(PaginatorInterface $paginator): void;
}
