<?php

namespace Flipbox\Relay\Salesforce\Middleware\Resource;

use Flipbox\Relay\Salesforce\Middleware\Resource;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Search extends Resource
{
    /**
     * @var string
     */
    public $sosl;

    /**
     * The resource name
     */
    public $resource = 'search';

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
                    http_build_query(['q' => $this->sosl])
                )
        );

        return parent::__invoke($request, $response, $next);
    }
}
