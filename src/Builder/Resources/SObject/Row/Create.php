<?php

namespace Flipbox\Relay\Salesforce\Builder\Resources\SObject\Row;

use Flipbox\Relay\Salesforce\AuthorizationInterface;
use Flipbox\Relay\Salesforce\Builder\HttpRelayBuilder;
use Flipbox\Relay\Salesforce\InstanceInterface;
use Flipbox\Relay\Salesforce\Middleware\JsonRequest as JsonMiddleware;
use Flipbox\Relay\Salesforce\Middleware\Resource\SObject\Row;
use Psr\Log\LoggerInterface;

class Create extends HttpRelayBuilder
{
    /**
     * Upsert constructor.
     * @param InstanceInterface $instance
     * @param AuthorizationInterface $authorization
     * @param $sObject
     * @param $payload
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        InstanceInterface $instance,
        AuthorizationInterface $authorization,
        string $sObject,
        array $payload,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($instance, $authorization, $logger, $config);

        $this->addPayload($payload, $logger)
            ->addUri($sObject, $logger);
    }

    /**
     * @param array $payload
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addPayload(array $payload, LoggerInterface $logger = null)
    {
        return $this->addAfter('body', [
            'class' => JsonMiddleware::class,
            'payload' => $payload,
            'logger' => $logger ?: $this->getLogger()
        ], 'instance');
    }

    /**
     * @param string $sobject
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $sobject, LoggerInterface $logger = null)
    {
        return $this->addAfter('uri', [
            'class' => Row::class,
            'sobject' => $sobject,
            'method' => 'POST',
            'logger' => $logger ?: $this->getLogger(),
        ], 'body');
    }
}
