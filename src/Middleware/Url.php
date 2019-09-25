<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-salesforce/blob/master/LICENSE.md
 * @link       https://github.com/flipbox/relay-salesforce
 */

namespace Flipbox\Relay\Salesforce\Middleware;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class Url extends AbstractMiddleware
{
    /**
     * The request method
     */
    public $method = 'GET';

    /**
     * The url
     */
    public $url;

    /**
     * @inheritdoc
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        parent::__invoke($request, $response, $next);

        $request = $this->prepareUri(
            $request->withMethod($this->method)
        );

        return $next($request, $response);
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    protected function prepareUri(RequestInterface $request)
    {
        $uri = $request->getUri();
        return $request->withUri(
            $uri->withPath(
                rtrim($this->url, "/")  . "/"
            )
        );
    }
}
