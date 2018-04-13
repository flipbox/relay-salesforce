<?php

namespace Flipbox\Relay\Salesforce\Builder\Resources\SObject\Row;

use Flipbox\Relay\Middleware\Clear as CacheMiddleware;
use Flipbox\Relay\Salesforce\AuthorizationInterface;
use Flipbox\Relay\Salesforce\Builder\HttpRelayBuilder;
use Flipbox\Relay\Salesforce\InstanceInterface;
use Flipbox\Relay\Salesforce\Middleware\Resource\SObject\Row;
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
     * @param string $id
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        InstanceInterface $instance,
        AuthorizationInterface $authorization,
        CacheItemPoolInterface $cache,
        string $sObject,
        string $id,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($instance, $authorization, $logger, $config);

        $this->addUri($sObject, $id, $logger)
            ->addCache($cache, $id, $logger);
    }

    /**
     * @param string $sobject
     * @param string|null $id
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $sobject, string $id, LoggerInterface $logger = null)
    {
        return $this->addAfter('uri', [
            'class' => Row::class,
            'sobject' => $sobject,
            'id' => $id,
            'method' => 'DELETE',
            'logger' => $logger ?: $this->getLogger(),
        ], 'instance');
    }

    /**
     * @param CacheItemPoolInterface $cache
     * @param string|null $key
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addCache(CacheItemPoolInterface $cache, string $key = null, LoggerInterface $logger = null)
    {
        return $this->addBefore('cache', [
            'class' => CacheMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
            'pool' => $cache,
            'key' => $key
        ], 'token');
    }
}
