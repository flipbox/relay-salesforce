<?php

/**
 * REST Middleware
 *
 * @package    Force
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://flipboxfactory.com/software/craft/force/license
 * @version    Release: 1.3.0
 * @link       https://github.com/FlipboxFactory/Force
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Relay\Salesforce\Middleware;

use Flipbox\Http\Stream\Factory as StreamFactory;
use Flipbox\Relay\Middleware\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class JsonRequest extends AbstractMiddleware
{
    /**
     * @var array
     */
    public $payload;

    /**
     * @inheritdoc
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        parent::__invoke($request, $response, $next);

        if ($this->payload !== null) {
            $request = $request->withBody(
                StreamFactory::create(
                    json_encode($this->payload)
                )
            );
        }

        return $next($request, $response);
    }
}
