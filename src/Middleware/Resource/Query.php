<?php

namespace Flipbox\Relay\Salesforce\Middleware\Resource;

use Flipbox\Relay\Salesforce\Middleware\Resource;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Query extends Resource
{
    /**
     * @var string
     */
    public $soql;

    /**
     * The resource name
     */
    public $resource = 'query';

    /**
     * @inheritdoc
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $request = $request->withUri(
            $request->getUri()
                ->withQuery(
                    http_build_query(['q' => $this->soql])
                )
        );

        return parent::__invoke($request, $response, $next);
    }
}
