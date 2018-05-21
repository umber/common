<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Method\Header;

use Umber\Common\Authentication\Method\AuthenticationHeaderInterface;

final class StringAuthorisationHeader implements AuthenticationHeaderInterface
{
    /** @var AuthenticationHeaderInterface */
    private $header;

    public function __construct(string $string)
    {
        $parts = explode(' ', $string);

        $this->header = new AuthorisationHeader(
            $parts[0],
            $parts[1]
        );
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
