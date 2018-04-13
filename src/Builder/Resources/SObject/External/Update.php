<?php

namespace Flipbox\Relay\Salesforce\Builder\Resources\SObject\External;

use Flipbox\Relay\Middleware\Clear as CacheMiddleware;
use Flipbox\Relay\Salesforce\AuthorizationInterface;
use Flipbox\Relay\Salesforce\Builder\HttpRelayBuilder;
use Flipbox\Relay\Salesforce\InstanceInterface;
use Flipbox\Relay\Salesforce\Middleware\JsonRequest as JsonMiddleware;
use Flipbox\Relay\Salesforce\Middleware\Resource\SObject\External;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

class Update extends HttpRelayBuilder
{
    /**
     * Upsert constructor.
     * @param InstanceInterface $instance
     * @param AuthorizationInterface $authorization
     * @param CacheItemPoolInterface $cache
     * @param $sObject
     * @param $payload
     * @param string $fieldName
     * @param string $fieldValue
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        InstanceInterface $instance,
        AuthorizationInterface $authorization,
        CacheItemPoolInterface $cache,
        string $sObject,
        array $payload,
        string $fieldName,
        string $fieldValue,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($instance, $authorization, $logger, $config);

        $this->addPayload($payload, $logger)
            ->addUri($sObject, $fieldName, $fieldValue, $logger)
            ->addCache($cache, $logger);
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
     * @param string $fieldName
     * @param string $fieldValue
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $sobject, string $fieldName, string $fieldValue, LoggerInterface $logger = null)
    {
        return $this->addAfter('uri', [
            'class' => External::class,
            'sobject' => $sobject,
            'fieldName' => $fieldName,
            'fieldValue' => $fieldValue,
            'method' => 'PATCH',
            'logger' => $logger ?: $this->getLogger(),
        ], 'body');
    }

    /**
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addCache(CacheItemPoolInterface $cache, LoggerInterface $logger = null)
    {
        return $this->addBefore('cache', [
            'class' => CacheMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
            'pool' => $cache
        ], 'token');
    }
}
