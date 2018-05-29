<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Framework\Method\Header;

use Umber\Common\Authentication\Method\AuthenticationHeaderInterface;
use Umber\Common\Authentication\Method\Header\StringAuthorisationHeader;
use Umber\Common\Exception\Authentication\Framework\Method\Header\RequestAuthorisationHeaderMissingException;

use Symfony\Component\HttpFoundation\Request;

/**
 * {@inheritdoc}
 */
final class RequestAuthorisationHeader implements AuthenticationHeaderInterface
{
    public const AUTHORISATION_HEADER = 'Authorization';

    /** @var AuthenticationHeaderInterface */
    private $header;

    /**
     * @throws RequestAuthorisationHeaderMissingException when the header is missing.
     */
    public function __construct(Request $request)
    {
        $string = $request->headers->get(self::AUTHORISATION_HEADER, null);

        if ($string === null) {
            throw RequestAuthorisationHeaderMissingException::create();
        }

        $this->header = new StringAuthorisationHeader($string);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->header->getType();
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(): string
    {
        return $this->header->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->header->toString();
    }

    /**
     * Magic conversion to string.
     */
    public function __toString()
    {
        return $this->toString();
    }
}
