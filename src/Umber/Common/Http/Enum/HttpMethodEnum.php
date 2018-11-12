<?php

declare(strict_types=1);

namespace Umber\Common\Http\Enum;

use Symfony\Component\HttpFoundation\Request;

final class HttpMethodEnum
{
    public const METHOD_HEAD = Request::METHOD_HEAD;
    public const METHOD_GET = Request::METHOD_GET;
    public const METHOD_POST = Request::METHOD_POST;
    public const METHOD_PUT = Request::METHOD_PUT;
    public const METHOD_PATCH = Request::METHOD_PATCH;
    public const METHOD_DELETE = Request::METHOD_DELETE;
    public const METHOD_PURGE = Request::METHOD_PURGE;
    public const METHOD_OPTIONS = Request::METHOD_OPTIONS;
    public const METHOD_TRACE = Request::METHOD_TRACE;
    public const METHOD_CONNECT = Request::METHOD_CONNECT;
    public const METHOD_LINK = 'LINK';
    public const METHOD_UNLINK = 'UNLINK';
}
