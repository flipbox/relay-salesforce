<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-salesforce/blob/master/LICENSE.md
 * @link       https://github.com/flipbox/relay-salesforce
 */

namespace Flipbox\Relay\Salesforce\Builder;

use Flipbox\Relay\Builder\RelayBuilder;
use Flipbox\Relay\Salesforce\AuthorizationInterface;
use Flipbox\Relay\Salesforce\InstanceInterface;
use Flipbox\Relay\Salesforce\Middleware\Authorization as AuthorizationMiddleware;
use Flipbox\Relay\Salesforce\Middleware\Client as ClientMiddleware;
use Flipbox\Relay\Salesforce\Middleware\Instance as InstanceMiddleware;
use Psr\Log\LoggerInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class HttpRelayBuilder extends RelayBuilder
{
    /**
     * @param InstanceInterface $instance
     * @param AuthorizationInterface $authorization
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        InstanceInterface $instance,
        AuthorizationInterface $authorization,
        LoggerInterface $logger = null,
        array $config = []
    ) {
        parent::__construct(
            $config
        );

        $this->addInstance($instance, $logger)
            ->addAuthorization($authorization, $logger)
            ->addClient($logger);
    }

    /**
     * @param InstanceInterface $instance
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addInstance(InstanceInterface $instance, LoggerInterface $logger = null)
    {
        return $this->addBefore('instance', [
            'class' => InstanceMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
            'instance' => $instance
        ]);
    }

    /**
     * @param AuthorizationInterface $authorization
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addAuthorization(
        AuthorizationInterface $authorization,
        LoggerInterface $logger = null
    ) {
        return $this->addAfter('token', [
            'class' => AuthorizationMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
            'authorization' => $authorization
        ], 'cache');
    }

    /**
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addClient(LoggerInterface $logger = null)
    {
        return $this->addAfter('client', [
            'class' => ClientMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
        ], 'token');
    }
}
