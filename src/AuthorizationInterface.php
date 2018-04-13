<?php

namespace Flipbox\Relay\Salesforce;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface AuthorizationInterface
{
    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function prepareAuthorizationRequest(
        RequestInterface $request
    ): RequestInterface;

    /**
     * Allow interpretation and subsequent authorization re-tries.
     *
     * @param ResponseInterface $response
     * @param RequestInterface $request
     * @param callable $callable
     * @return ResponseInterface
     */
    public function handleAuthorizationResponse(
        ResponseInterface $response,
        RequestInterface $request,
        callable $callable
    ): ResponseInterface;
}