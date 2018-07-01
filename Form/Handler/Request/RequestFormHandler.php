<?php

declare(strict_types=1);

namespace Umber\Common\Form\Handler\Request;

use Umber\Common\Form\Handler\FormHandler;
use Umber\Common\Utility\JsonHttpHelper;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * {@inheritdoc}
 */
final class RequestFormHandler implements RequestFormHandlerInterface
{
    private $formHandler;
    private $requestStack;

    public function __construct(FormHandler $formHandler, RequestStack $requestStack)
    {
        $this->formHandler = $formHandler;
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Request $request, string $type, $data = null, array $options = []): FormInterface
    {
        $payload = JsonHttpHelper::request($request);

        //  PATCH requests would indicate that missing values are to be ignored or null.
        $missing = ($request->getMethod() !== Request::METHOD_PATCH);
        $form = $this->formHandler->handle($type, $payload, $data, $options, $missing);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function handleCurrentRequest(string $type, $data = null, array $options = []): FormInterface
    {
        $request = $this->requestStack->getCurrentRequest();

        $form = $this->handleRequest($request, $type, $data, $options);

        return $form;
    }
}
