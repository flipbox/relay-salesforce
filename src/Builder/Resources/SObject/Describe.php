<?php

namespace Flipbox\Relay\Salesforce\Builder\Resources\SObject;

use Flipbox\Relay\Middleware\Stash as CacheMiddleware;
use Flipbox\Relay\Salesforce\AuthorizationInterface;
use Flipbox\Relay\Salesforce\Builder\HttpRelayBuilder;
use Flipbox\Relay\Salesforce\InstanceInterface;
use Flipbox\Relay\Salesforce\Middleware\Resource\SObject\Describe as DescribeMiddleware;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

class Describe extends HttpRelayBuilder
{
    /**
     * Upsert constructor.
     * @param InstanceInterface $instance
     * @param AuthorizationInterface $authorization
     * @param CacheItemPoolInterface $cache
     * @param string $sObject
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        InstanceInterface $instance,
        AuthorizationInterface $authorization,
        CacheItemPoolInterface $cache,
        string $sObject,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($instance, $authorization, $logger);

        $this->addUri($sObject, $logger)
            ->addCache($cache, $logger);
    }

    /**
     * @param string $sobject
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $sobject, LoggerInterface $logger = null)
    {
        return $this->addAfter('uri', [
            'class' => DescribeMiddleware::class,
            'sobject' => $sobject,
            'logger' => $logger ?: $this->getLogger()
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
