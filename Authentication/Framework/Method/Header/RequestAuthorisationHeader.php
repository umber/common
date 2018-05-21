<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Framework\Method\Header;

use Umber\Common\Authentication\Method\AuthenticationHeaderInterface;
use Umber\Common\Authentication\Method\Header\StringAuthorisationHeader;

use Symfony\Component\HttpFoundation\Request;

final class RequestAuthorisationHeader implements AuthenticationHeaderInterface
{
    public const AUTHORISATION_HEADER = 'Authorization';

    /** @var AuthenticationHeaderInterface */
    private $header;

    /**
     *
     *
     *
     * @throws \Exception
     */
    public function __construct(Request $request)
    {
        $string = $request->headers->get(self::AUTHORISATION_HEADER, null);

        if ($string === null) {
            throw new \Exception('header missing');
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
}
