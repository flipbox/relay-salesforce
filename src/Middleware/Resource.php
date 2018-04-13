<?php

namespace Flipbox\Relay\Salesforce\Middleware;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Resource extends AbstractMiddleware
{
    /**
     * The request method
     */
    public $method = 'GET';

    /**
     * The resource name
     */
    public $resource;

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
                $this->assembleUri($uri->getPath())
            )
        );
    }

    /**
     * @param string|null $baseUri
     * @return string
     */
    protected function assembleUri(string $baseUri = null): string
    {
        return ($baseUri ? $baseUri . '/' : '') . $this->assemblePath();
    }

    /**
     * @inheritdoc
     */
    protected function assemblePath(): string
    {
        return $this->resource ? $this->resource . '/' : '';
    }
}
