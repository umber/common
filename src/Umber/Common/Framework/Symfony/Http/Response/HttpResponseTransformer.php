<?php

declare(strict_types=1);

namespace Umber\Common\Framework\Symfony\Http\Response;

use Umber\Common\Http\Enum\HttpHeaderEnum;
use Umber\Common\Http\Enum\HttpMethodEnum;
use Umber\Common\Http\Header\Configuration\AccessControlConfiguration;
use Umber\Common\Http\Header\Generator\AdditionalResponseHeaderGenerator;
use Umber\Common\Http\HttpResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * A http response transform for Symfony framework.
 */
final class HttpResponseTransformer
{
    private $generator;

    public function __construct(AdditionalResponseHeaderGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Apply additional headers and transform the internal response to one that can
     * be used by Symfony framework.
     */
    public function transform(HttpResponse $response, Request $request): Response
    {
        $origin = $request->headers->get(HttpHeaderEnum::ORIGIN, '*');
        $methods = $this->getAllowedMethodForRoute($request);

        // 60 minutes.
        $age = 60 * 60;

        $configuration = new AccessControlConfiguration($origin, $methods, $age);
        $this->generator->generate($response, $configuration);

        $built = $response->build();

        return $built;
    }

    /**
     * Resolve the request and get all allowed HTTP methods.
     *
     * @return string[]
     */
    private function getAllowedMethodForRoute(Request $request): array
    {
        return [
            HttpMethodEnum::METHOD_GET,
            HttpMethodEnum::METHOD_POST,
        ];
    }
}
