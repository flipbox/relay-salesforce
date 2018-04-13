<?php

namespace Flipbox\Relay\Salesforce\Builder\Resources\SObject\External;

use Flipbox\Relay\Middleware\Clear as CacheMiddleware;
use Flipbox\Relay\Salesforce\AuthorizationInterface;
use Flipbox\Relay\Salesforce\Builder\HttpRelayBuilder;
use Flipbox\Relay\Salesforce\InstanceInterface;
use Flipbox\Relay\Salesforce\Middleware\Resource\SObject\External;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

class Delete extends HttpRelayBuilder
{
    /**
     * Upsert constructor.
     * @param InstanceInterface $instance
     * @param AuthorizationInterface $authorization
     * @param CacheItemPoolInterface $cache
     * @param $sObject
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
        string $fieldName,
        string $fieldValue,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($instance, $authorization, $logger);

        $this->addUri($sObject, $fieldName, $fieldValue, $logger)
            ->addCache($cache, $logger);
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
            'method' => 'DELETE',
            'logger' => $logger ?: $this->getLogger(),
        ], 'instance');
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