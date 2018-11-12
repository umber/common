<?php

declare(strict_types=1);

namespace Umber\Common\Http\Header\Configuration;

/**
 * Cross origin and access control configuration.
 */
final class AccessControlConfiguration
{
    private $origin;
    private $methods;
    private $age;

    /**
     * @param string[] $methods
     */
    public function __construct(string $origin, array $methods, int $age)
    {
        $this->origin = $origin;
        $this->methods = $methods;
        $this->age = $age;
    }

    /**
     * Return the origin.
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }

    /**
     * Return the exposed methods.
     *
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * Return the cache max age.
     */
    public function getAge(): int
    {
        return $this->age;
    }
}
