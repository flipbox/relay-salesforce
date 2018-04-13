<?php

namespace Flipbox\Relay\Salesforce\Middleware;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use Flipbox\Relay\Salesforce\AuthorizationInterface;
use Flipbox\Skeleton\Exceptions\InvalidConfigurationException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Authorization extends AbstractMiddleware
{
    /**
     * @var AuthorizationInterface
     */
    public $authorization;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!$this->authorization instanceof AuthorizationInterface) {
            throw new InvalidConfigurationException(sprintf(
                "The class '%s' requires an authorization class that is an instance of '%s', '%s' given.",
                get_class($this),
                AuthorizationInterface::class,
                get_class($this->authorization)
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

        $request = $this->authorization->prepareAuthorizationRequest($request);

        // Clone in case we need to refresh and resend
        $runner = clone $next;

        return $this->authorization->handleAuthorizationResponse(
            $next($request, $response),
            $request,
            $runner
        );
    }
}
