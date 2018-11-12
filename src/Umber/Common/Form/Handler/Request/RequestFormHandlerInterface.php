<?php

declare(strict_types=1);

namespace Umber\Common\Form\Handler\Request;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * A form handle that works with Symfony Request.
 */
interface RequestFormHandlerInterface
{
    /**
     * Create and handle a form for the Symfony Request given.
     *
     * @param mixed $data
     * @param mixed[] $options
     */
    public function handleRequest(Request $request, string $type, $data = null, array $options = []): FormInterface;

    /**
     * Create and handle a form for the current Symfony Request in the Request Stack.
     *
     * @param mixed $data
     * @param mixed[] $options
     */
    public function handleCurrentRequest(string $type, $data = null, array $options = []): FormInterface;
}
