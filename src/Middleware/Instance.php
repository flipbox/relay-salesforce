<?php

namespace Flipbox\Relay\Salesforce\Middleware;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use Flipbox\Relay\Salesforce\InstanceInterface;
use Flipbox\Skeleton\Exceptions\InvalidConfigurationException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Instance extends AbstractMiddleware
{
    /**
     * @var InstanceInterface
     */
    public $instance;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!$this->instance instanceof InstanceInterface) {
            throw new InvalidConfigurationException(sprintf(
                "The class '%s' requires a instance class that is an instance of '%s', '%s' given.",
                get_class($this),
                InstanceInterface::class,
                get_class($this->instance)
            ));
        }
    }

    /**
     * @inheritdoc
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        parent::__invoke($request, $response, $next);
        $request = $this->instance->prepareInstanceRequest($request);
        return $next($request, $response);
    }
}
