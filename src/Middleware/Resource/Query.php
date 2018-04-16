<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-salesforce/blob/master/LICENSE.md
 * @link       https://github.com/flipbox/relay-salesforce
 */

namespace Flipbox\Relay\Salesforce\Middleware\Resource;

use Flipbox\Relay\Salesforce\Middleware\Resource;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
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
