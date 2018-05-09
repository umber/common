<?php

declare(strict_types=1);

namespace Umber\Common\Kernel;

abstract class AbstractEnvironment
{
    private $environment;
    private $debug;

    public function __construct(string $environment, bool $debug)
    {
        $this->environment = $environment;
        $this->debug = $debug;
    }

    /**
     * Check if the environment is in debug mode.
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * Check the current environment is as specified.
     */
    public function is(string $environment): bool
    {
        return $this->environment === $environment;
    }
}
