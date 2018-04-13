<?php

namespace Flipbox\Relay\Salesforce;

use Psr\Http\Message\RequestInterface;

interface InstanceInterface
{
    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function prepareInstanceRequest(RequestInterface $request): RequestInterface;
}