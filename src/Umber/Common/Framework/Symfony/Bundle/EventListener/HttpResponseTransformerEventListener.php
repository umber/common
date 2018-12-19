<?php

declare(strict_types=1);

namespace Umber\Common\Framework\Symfony\Bundle\EventListener;

use Umber\Common\Framework\Symfony\Http\Response\HttpResponseTransformer;

use Umber\Http\HttpResponse;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

/**
 * An event listener pre-built to handle the transformation of HTTP responses that
 * are returned from the controller by library code.
 */
final class HttpResponseTransformerEventListener
{
    private $transformer;

    public function __construct(HttpResponseTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Handle transformation.
     */
    public function onKernelView(GetResponseForControllerResultEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $response = $event->getControllerResult();
        $request = $event->getRequest();

        if (!$response instanceof HttpResponse) {
            return;
        }

        $transformed = $this->transformer->transform($response, $request);

        $event->setResponse($transformed);
    }
}
