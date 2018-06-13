<?php

declare(strict_types=1);

namespace Umber\Common\Test;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

/**
 * A trait that adds a request helper for functional testing.
 *
 * @mixin \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
 * @mixin \PHPUnit\Framework\TestCase
 */
trait SymfonyFunctionalRequestTrait
{
    /** @var Client */
    protected $client;

    /** @var string */
    private $authenticationCredentials;
    private $authenticationType;

    /**
     * Authenticate the requests being made.
     */
    protected function authenticate(string $type, string $credentials): void
    {
        $this->authenticationType = $type;
        $this->authenticationCredentials = $credentials;
    }

    /**
     * Make simplified requests.
     *
     * @param mixed[]|null $parameters
     * @param mixed[]|null $payload
     * @param string[]|null $headers
     */
    protected function request(
        string $method,
        string $path,
        ?array $parameters,
        ?array $payload,
        ?array $headers,
        bool $catchException = true
    ): Response {
        $json = null;

        $parameters = $parameters ?? [];

        $headers = $headers ?? [];
        $headers['HTTP_AUTHORIZATION'] = sprintf(
            '%s %s',
            $this->authenticationType,
            $this->authenticationCredentials
        );

        if ($payload !== null) {
            $json = json_encode($payload);
        }

        $this->client->catchExceptions($catchException);
        $this->client->request($method, $path, $parameters, [], $headers, $json);

        return $this->client->getResponse();
    }
}
